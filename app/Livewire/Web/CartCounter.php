<?php

namespace App\Livewire\Web;

use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Livewire\Component;

class CartCounter extends Component
{
    public $count = 0; // Initialize the count property

    protected $listeners = ['updatedCartCount' => 'cartCountUpdated'];

    public function mount()
    {
        $this->cartCountUpdated(); // Call the method to set the initial count
    }

    public function cartCountUpdated()
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
        $this->count = Cart::where('cookie', $clientCode)->count(); // Update the count based on the user's cart
    }

    public function render()
    {
        return view('livewire.web.cart-counter');
    }
}
