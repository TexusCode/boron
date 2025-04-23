<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Controllers\SmsController;
use App\Models\Cart;
use App\Models\City;
use App\Models\Coupone;
use App\Models\Favorite;
use App\Models\OderCheckout;
use App\Models\Order;
use App\Models\Product;
use App\Models\Seller;
use App\Models\SubCategory;
use App\Models\SubOrder;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;

class PagesController extends Controller
{
    public function filters(Request $request)
    {
        $products = Product::whereHas('seller', function ($query) {
            $query->where('status', true);
        })->orderBy('created_at', 'desc')->where('status', true)->paginate(36);
        if ($request->ajax()) {
            $view = view('web.loads', compact('products'))->render();
            return Response::json(['view' => $view, 'nextPageUrl' => $products->nextPageUrl()]);
        }
        return view('web.pages.filter-sort', compact('products'));
    }
    public function checkoutpost(Request $request)
    {
        $clientCode = Cookie::get('client_code');
        $ordercheckout = OderCheckout::where('cookie', $clientCode)->first();
        $maxOrderNumber = Order::max('no') ?? 0; // Если нет заказов, начнем с 0

        if (!$ordercheckout) {
            return redirect()->route('cart')->with('error', 'Не удалось найти данные заказа.');
        }

        // Определяем пользователя, если он аутентифицирован
        if (Auth::check()) {
            $user = Auth::user();
            $user->name = $request->name;
            $user->save();

            $phone = $user->phone;
            $orderStatus = 'Ожидание';
        } else {
            $phone = $request->phone;
            $user = User::firstOrCreate(['phone' => $phone]);

            if (!$user->wasRecentlyCreated && $user->name !== $request->name) {
                $user->name = $request->name;
                $user->save();
            }

            $orderStatus = 'Неподтверждено';
        }

        // Создаем новый заказ
        $order = new Order();
        $order->no = $maxOrderNumber + 1;
        $order->user_id = $user->id;
        $order->subtotal = $ordercheckout->subtotal;
        $order->delivery_price = $ordercheckout->delivery_price;
        $order->coupone_code = $ordercheckout->coupone_code;
        $order->tax = $ordercheckout->tax;
        $order->discount = $ordercheckout->discount;
        $order->total = $ordercheckout->total;
        $order->city = $request->city;
        $order->location = $request->location;
        $order->payment = $request->payment;
        $order->delivery_type = $request->delivery_type;
        $order->status = $orderStatus;
        $order->save();

        // Создаем подзаказы
        $suborders = Cart::where('cookie', $clientCode)->get();

        foreach ($suborders as $suborder) {
            $product = Product::find($suborder->product_id);
            $discount = 0; // Initialize discount with a default value

            if ($product) {
                $pprice = $product->discount ?? $product->price; // Use discount if available, else regular price

                // Check for coupon code and calculate discount
                if (!empty($order->coupone_code)) {
                    $coupon = Coupone::where('code', $order->coupone_code)->first();
                    if ($coupon) {
                        $discount = ($coupon->percent * $pprice) / 100;
                    }
                }

                SubOrder::create([
                    'order_id' => $order->id,
                    'product_id' => $suborder->product_id,
                    'count' => $suborder->count,
                    'price' => $pprice,
                    'discount' => $discount,
                    'seller_id' => $product->seller->id,
                ]);
            }
        }


        // Очистка данных заказа
        $ordercheckout->delete();
        Cart::where('cookie', $clientCode)->delete();

        if (Auth::check()) {
            $message = "Ассалому алейкум, {$user->name}!\nВаш заказ №{$order->id} успешно получен!\nСтатус: Ожидание.\nМы уведомим вас, как только заказ будет подтвержден.\nСпасибо, что выбрали нас!";
        } else {
            $verificationCode = rand(100000, 999999);
            Session::put('verification_code', $verificationCode);
            Session::put('phone', $phone);
            Session::put('order_id', $order->id);

            $message = "Код подтверждения для заказа: $verificationCode";
            $smsController = new SmsController();
            $smsController->sendSms($phone, $message);
            return redirect()->route('order-verify');
        }

        $smsController = new SmsController();
        $smsController->sendSms($phone, $message);

        return redirect()->route('home')->with('success', 'Ваш заказ успешно получен');
    }

    public function orderverification(Request $request)
    {
        $code = $request->input('code_1') .
            $request->input('code_2') .
            $request->input('code_3') .
            $request->input('code_4') .
            $request->input('code_5') .
            $request->input('code_6');
        $sessionVerificationCode = Session::get('verification_code');

        if ($code == $sessionVerificationCode) {
            $orderId = Session::get('order_id');
            $order = Order::find($orderId);

            if ($order) {
                $order->status = 'Ожидание';
                $order->save();

                $phone = Session::get('phone');
                $user = User::where('phone', $phone)->first();

                if ($user) {
                    $message = "Ассалому алейкум, {$user->name}!\nВаш заказ №{$order->id} успешно получен!\nСтатус: Ожидание.\nСпасибо, что выбрали нас!";
                    $smsController = new SmsController();
                    $smsController->sendSms($phone, $message);
                }

                // Очищаем сессионные данные по отдельности
                Session::forget('verification_code');
                Session::forget('phone');
                Session::forget('order_id');

                return redirect()->route('home')->with('success', 'Ваш заказ успешно подтвержден');
            }

            return redirect()->route('home')->with('error', 'Не удалось найти заказ.');
        }

        return back()->with('error', 'Код неверный!');
    }




    public function orderverify()
    {
        return view('web.pages.order-verification');
    }

    public function discountedproducts()
    {
        $products = Product::whereHas('seller', function ($query) {
            $query->where('status', true);
        })
            ->where('status', true)
            ->where('discount', '>', 0) // Убедитесь, что поле discount не пустое
            ->orderBy('created_at', 'desc')
            ->paginate(36);

        return view('web.pages.discounted-products', compact('products'));
    }
    public function sellers()
    {
        $sellers = Seller::where('status', true)->orderby('created_at', 'desc')->paginate(36);

        return view('web.pages.sellers', compact('sellers'));
    }
    public function sellerpage($id)
    {
        $seller = Seller::find($id);
        if (!$seller || !$seller->status) {
            return back();
        }
        $products = Product::where('seller_id', $seller->id)->where('status', true)->orderby('created_at', 'desc')->paginate(36);
        return view('web.pages.seller-page', compact('seller', 'products'));
    }

    public function search(Request $request)
    {
        $query = Product::query()
            ->where('status', true) // Фильтр по статусу продукта
            ->whereHas('seller', function ($query) {
                $query->where('status', true); // Фильтр по статусу продавца
            });

        // Поиск по имени или коду
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function ($subQuery) use ($searchTerm) {
                $subQuery->where('name', 'like', "%{$searchTerm}%")
                ->orWhere('code', 'like', "%{$searchTerm}%");
            });
        }

        // Фильтр по категории и её подкатегориям
        if ($request->filled('category')) {
            $subcategoryIds = SubCategory::where('category_id', $request->category)->pluck('id');
            $query->where(function ($q) use ($request, $subcategoryIds) {
                $q->where('category_id', $request->category)
                    ->orWhereIn('subcategory_id', $subcategoryIds);
            });
        }

        // Фильтр по подкатегории
        if ($request->filled('subcategory')) {
            $query->where('subcategory_id', $request->subcategory);
        }

        // Сортировка
        $sortDirection = $request->sort === 'asc' ? 'asc' : 'desc';
        $query->orderBy('created_at', $sortDirection);

        // Пагинация
        $products = $query->paginate(36);
        if ($request->ajax()) {
            $view = view('web.loads', compact('products'))->render();
            return Response::json(['view' => $view, 'nextPageUrl' => $products->nextPageUrl()]);
        }

        return view('web.pages.filter-sort', compact('products'));
    }


    public function details($id)
    {
        $product = Product::find($id);
        if (!$product) {
            return back()->with('info', 'Товар не найден');
        }
        $title = $product->name;
        $otherProducts = Product::whereHas('seller', function ($query) {
            $query->where('status', true);
        })
            ->where('status', true)
            ->inRandomOrder()
            ->take(36)
            ->get();

        return view('web.pages.details', compact('product', 'title', 'otherProducts'));
    }


    public function shopcart()
    {
        return view('web.pages.cart');
    }
    public function favorites()
    {
        $favorites = Favorite::where('user_id', Auth::id())->get();
        return view('web.pages.favorites', compact('favorites'));
    }

    public function checkout($id)
    {
        $ordercheckout = OderCheckout::find($id);
        $cities = City::all();
        return view('web.pages.checkout', compact('ordercheckout','cities'));
    }

    public function profile()
    {
        return view('web.pages.profile');
    }

    public function verification()
    {
        return view('verification');
    }
}
