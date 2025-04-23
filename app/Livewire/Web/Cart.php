<?php

namespace App\Livewire\Web;

use App\Models\Cart as ModelsCart;
use App\Models\Coupone;
use App\Models\Product;
use App\Models\OderCheckout;
use App\Models\Tax;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Livewire\Component;

class Cart extends Component
{
    public $user;
    public $subtotal;
    public $total;
    public $delivery = 0;
    public $tax = 0;
    public $coupone = 0;
    public $couponeinput;

    public function mount()
    {
        $this->updatedCart();
    }
    public function couponebutton()
    {
        $coupon = Coupone::where('code', $this->couponeinput)->first();

        if ($coupon) {
            $this->coupone = $coupon->percent;

            if ($this->coupone > 0) {
                $this->coupone = $this->coupone / 100;
                $this->coupone = $this->subtotal * $this->coupone;
                $this->total = $this->total - $this->coupone;
            }

            $this->dispatch(
                'alert',
                type: 'success',
                title: 'Купон успешно добавлено',
                position: 'top',
            );
        } else {
            $this->coupone = 0;

            $this->dispatch(
                'alert',
                type: 'error',
                title: 'Купон не существует!',
                position: 'top',
            );
        }
    }

    public function updatedCart()
    {
        $clientCode = Cookie::get('client_code');

        if ($clientCode) {
        } else {
            $code = random_int(100000, 999999);
            $lifetime = 60 * 24 * 2; // 2 дня
            Cookie::queue('client_code', $code, $lifetime);

            // Делаем редирект или возвращаем ответ
            return response()->json(['client_code' => $code]);
        }
        $cartItems = ModelsCart::where('cookie', $clientCode);
        foreach ($cartItems as $item) {
            if ($item->product->stock == 0) {
                $item->delete();
            }
        }
        $cartItems = ModelsCart::where('cookie', $clientCode)->get();
        if ($cartItems) {
            $this->subtotal = $cartItems->sum(function ($item) {
                if ($item->product->discount) {
                    return $item->product->discount * $item->count;
                } else {
                    return $item->product->price * $item->count;
                }
            });
        }
        $this->delivery = Tax::find(2)->tax;
        $this->tax = Tax::find(1)->tax;

        $this->tax = round($this->subtotal * ($this->tax / 100));
        $this->total = round($this->subtotal  + $this->delivery + $this->tax - $this->coupone);
        $this->user = $cartItems;
        $this->dispatch('updatedCartCount');
        $this->reset('coupone');
    }

    public function checkout()
    {
        $clientCode = Cookie::get('client_code');
        $checkout = OderCheckout::where('cookie', $clientCode)->first();
        if ($checkout) {
            $checkout->subtotal = $this->subtotal;
            $checkout->delivery_price = $this->delivery ?? 0;
            $checkout->coupone_code = $this->couponeinput ?? 0;
            $checkout->tax = $this->tax ?? 0;
            $checkout->discount = round($this->coupone) ?? 0;
            $checkout->total = $this->total;
        } else {
            $checkout = new OderCheckout();
            $checkout->cookie = $clientCode;
            $checkout->subtotal = $this->subtotal;
            $checkout->delivery_price = $this->delivery;
            $checkout->coupone_code = $this->couponeinput ?? 0;
            $checkout->tax = $this->tax;
            $checkout->discount = $this->coupone ?? 0;
            $checkout->total = $this->total;
        }
        $checkout->save();
        return redirect()->route('checkout', ['id' => $checkout->id]);
    }
    public function delete($cartId)
    {
        ModelsCart::find($cartId)->delete();
        $this->updatedCart();
        $this->dispatch(
            'alert',
            type: 'warning',
            title: 'Товар удален из корзины',
            position: 'top',
        );
    }
    public function plus($itemId)
    {
        $cartItem = ModelsCart::find($itemId);
        $product = Product::find($cartItem->product_id);
        if ($product->stock > $cartItem->count) {
            $cartItem->count += 1;
            $cartItem->save();
            $this->updatedCart();
        }
    }

    public function minus($itemId)
    {
        $cartItem = ModelsCart::find($itemId);
        if ($cartItem->count > 1) {
            $cartItem->count -= 1;
            $cartItem->save();
            $this->updatedCart();
        }
    }
    public function render()
    {
        return view('livewire.web.cart');
    }
}
