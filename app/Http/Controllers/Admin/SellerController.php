<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\SmsController;
use App\Models\Product;
use App\Models\Seller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SellerController extends Controller
{
    public function sellers(Request $request)
    {
        return $this->sellerList($request, 'all');
    }

    public function peendingsellers(Request $request)
    {
        return $this->sellerList($request, 'pending');
    }

    public function addseller()
    {
        return view('admin.pages.add-seeller');
    }

    public function showseller($id)
    {
        $seller = Seller::find($id);
        $products = Product::orderBy('created_at', 'desc')->where('seller_id', $seller->id)->paginate(36);
        return view('admin.pages.seller-details', compact('seller', 'products'));
    }

    public function activateseller($id)
    {
        $seller = Seller::find($id);
        $user = User::find($seller->user_id);
        if ($seller->status == true) {
            $seller->status = false;
            $user->isseller = false;
            $user->role = 'customer';
        } else {
            $seller->status = true;
            $user->isseller = true;
            $user->role = 'seller';
        }
        $seller->save();
        $user->save();


        return back()->with('success', 'Статус успешно обновлено!');
    }
    public function verifyseller($id)
    {
        $seller = Seller::find($id);
        if ($seller->isverified == true) {
            $seller->isverified = false;
        } else {
            $seller->isverified = true;
        }
        $seller->save();

        return back()->with('success', 'Статус успешно обновлено!');
    }

    public function addsellerpost(Request $request)
    {
        $user = User::where('phone', $request->store_phone)->first();

        if (!$user) {
            $user = new User();
            $user->phone = $request->store_phone;
            $user->isseller = true;
            $user->save();
        }

        $seller = Seller::where('store_phone', $request->store_phone)->first();

        if ($seller) {
            return back()->with('error', 'С данным номером уже зарегистрирован магазин. Пожалуйста, войдите в систему.');
        }

        $seller = new Seller();
        $seller->user_id = $user->id;
        $seller->store_name = $request->store_name;
        $seller->store_phone = $request->store_phone;
        $seller->description = $request->description;

        if ($request->hasFile('logo')) {
            $seller->logo = $request->file('logo')->store('seller', 'public');
        }
        if ($request->hasFile('patent')) {
            $seller->patent = $request->file('patent')->store('seller', 'public');
        }
        if ($request->hasFile('passport_front')) {
            $seller->passport_front = $request->file('passport_front')->store('seller', 'public');
        }
        if ($request->hasFile('passport_back')) {
            $seller->passport_back = $request->file('passport_back')->store('seller', 'public');
        }

        $seller->status = true;
        $seller->register_date = Carbon::now();
        $seller->save();

        $phone = $request->store_phone;
        $message = 'Мы получили вашу заявку на статус продавца! Сейчас она находится на модерации. Мы сообщим вам, как только ваш магазин будет одобрен.';
        $smsController = new SmsController();
        $sms = $smsController->sendSms($phone, $message);


        return redirect()->route('sellers')->with('success', 'Регистрация прошла успешно');
    }

    public function deleteseller($id)
    {
        $seller = Seller::findOrFail($id);

        // Деактивируем привязанные товары, чтобы скрыть их из каталога
        Product::where('seller_id', $seller->id)->update([
            'status' => false,
        ]);

        // Сбрасываем роль пользователя
        $user = User::find($seller->user_id);
        if ($user) {
            $user->isseller = false;
            if ($user->role === 'seller') {
                $user->role = 'customer';
            }
            $user->save();
        }

        $seller->delete();

        return back()->with('success', 'Продавец удалён');
    }

    protected function sellerList(Request $request, string $activeTab = 'all')
    {
        $query = Seller::query();

        if ($activeTab === 'pending') {
            $query->where('status', false);
        }

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('store_name', 'like', '%' . $search . '%')
                    ->orWhere('store_phone', 'like', '%' . $search . '%');
            });
        }

        $statusFilter = $request->input('status');
        if ($statusFilter === 'active') {
            $query->where('status', true);
        } elseif ($statusFilter === 'inactive') {
            $query->where('status', false);
        }

        $verifiedFilter = $request->input('verified');
        if ($verifiedFilter === 'yes') {
            $query->where('isverified', true);
        } elseif ($verifiedFilter === 'no') {
            $query->where('isverified', false);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('register_date', '>=', $request->input('date_from'));
        }
        if ($request->filled('date_to')) {
            $query->whereDate('register_date', '<=', $request->input('date_to'));
        }

        $sort = $request->input('sort', 'newest');
        switch ($sort) {
            case 'name_asc':
                $query->orderBy('store_name');
                break;
            case 'name_desc':
                $query->orderByDesc('store_name');
                break;
            case 'oldest':
                $query->orderBy('created_at');
                break;
            default:
                $query->orderByDesc('created_at');
        }

        $sellers = $query->paginate(25)->withQueryString();

        $filters = $request->only(['search', 'status', 'verified', 'date_from', 'date_to', 'sort']);

        return view('admin.pages.sellers', compact('sellers', 'filters', 'activeTab'));
    }
}
