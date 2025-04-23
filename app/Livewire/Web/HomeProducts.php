<?php

namespace App\Livewire\Web;


use Livewire\Component;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
class HomeProducts extends Component
{
    public $products;
    public $count = 25;
    public $isLoading = false;
    protected $listeners = ['cartUpdated' => 'updateCart'];

    public function mount()
    {
        $newProducts = Product::whereHas('seller', function ($query) {
            $query->where('status', true);
        })->where('status', true)
            ->take(500)
            ->get();

        $this->products = $newProducts;
    }
    public function updateCart()
    {

        $newProducts = Product::whereHas('seller', function ($query) {
        $query->where('status', true);
        })->where('status', true)
            ->inRandomOrder()
            ->take(25)
            ->get();

        $this->products = $this->products->merge($newProducts)->unique('id');
    }
    public function loading()
    {
        $this->count += 25;
    }
    public function add($id)
    {
        dd($id);
    }
    public function render()
    {
        return view('livewire.web.home-products');
    }
}
