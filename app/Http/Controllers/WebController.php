<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\Seller;
use App\Models\Slider;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

class WebController extends Controller
{
    public function home(Request $request)
    {
        $products = Product::whereHas('seller', function ($query) {
            $query->where('status', true);
        })
            ->where('status', true)
            ->where('stock', '>', 0)
            ->inRandomOrder()
            ->paginate(54);

        if ($request->ajax()) {
            $view = view('web.loads', compact('products'))->render();
            return Response::json(['view' => $view, 'nextPageUrl' => $products->nextPageUrl()]);
        }
        $sliders = Slider::all();
        // $categories = Category::where("ishome", true)->take(12)->get();
        $categories = Category::where('sort', '>', 0)->orderBy('sort')->where("ishome", true)->take(12)->get();

        return view('web.pages.home', compact('products', 'categories', 'sliders'));
    }

    public function myorders()
    {

        return view('web.pages.my-orders');
    }
    public function cancelorder($id)
    {
        $order = Order::find($id);
        $order->status = 'Отменено';
        $order->save();

        return back();
    }
    public function becomeaseller()
    {

        return view('web.pages.become-a-seller');
    }



    public function sellerregister(Request $request)
    {
        $user = User::where('phone', $request->store_phone)->first();

        if (!$user) {
            $user = new User();
            $user->phone = $request->store_phone;
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

        $seller->register_date = Carbon::now();
        $seller->save();

        $phone = $request->store_phone;
        $message = 'Мы получили вашу заявку на статус продавца! Сейчас она находится на модерации. Мы сообщим вам, как только ваш магазин будет одобрен.';
        $smsController = new SmsController();
        $sms = $smsController->sendSms($phone, $message);


        return redirect()->route('home')->with('success', 'Регистрация прошла успешно');
    }
}
