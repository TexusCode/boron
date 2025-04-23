<?php

namespace App\Livewire;

use App\Models\Cart;
use App\Models\Favorite;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Livewire\Component;

class ProduuctDetailsAddToCartFavorie extends Component
{
    public $id;
    public $cart;
    public $isfavorite = false;
    public $favorite;
    public function mount($id)
    {
        $this->id = $id;
        $this->favorite = Favorite::where('user_id', Auth::id())->where('product_id', $this->id)->first();
        $this->isfavorite = $this->favorite ? true : false;
    }
    public function addToCart()
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


        $this->cart = Cart::where('cookie', $clientCode)->where('product_id', $this->id)->first();

        if ($this->cart) {
            $this->dispatch(
                'alert',
                type: 'warning',
                title: 'Товар уже находится в корзине',
                position: 'top',
            );
            return;
        }

        $product = Product::find($this->id);
        if ($product && $product->stock > 0) {
            $add = new Cart();
            $add->cookie = $clientCode;
            $add->product_id = $this->id;
            $add->count = 1;
            $add->save();

            $this->dispatch(
                'alert',
                type: 'success',
                title: 'Товар успешно добавлен в корзину',
                position: 'top',
            );
        } else {
            $this->dispatch(
                'alert',
                type: 'error',
                title: 'Товар нет в наличии',
                position: 'top',
            );
        }

        $this->dispatch('updatedCartCount');
    }

    public function AddToFavorite()
    {
        if (Auth::check()) {
            if ($this->favorite) {
                $this->favorite->delete();
                $this->dispatch(
                    'alert',
                    type: 'warning',
                    title: 'Товар удалено из избранные',
                    position: 'top',
                );
                $this->isfavorite = false;
            } else {
                $add = new Favorite();
                $add->user_id = Auth::id();
                $add->product_id = $this->id;
                $add->save();

                $this->dispatch(
                    'alert',
                    type: 'success',
                    title: 'Товар успешно добавлен в избранные',
                    position: 'top',
                );
                $this->isfavorite = true;
            }
            $this->favorite = Favorite::where('user_id', Auth::id())->where('product_id', $this->id)->first();
            $this->dispatch('updatedFavoriteCount');
        } else {
            $this->dispatch(
                'alert',
                type: 'warning',
                title: 'Войдите в систему!',
                position: 'top',
            );
        }
    }
    public function render()
    {
        return view('livewire.produuct-details-add-to-cart-favorie');
    }
}
