<?php

namespace App\Livewire\Seller;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class MoySkladTogle extends Component
{
    public $togle;

    public function mount()
    {
        // Предполагается, что moy_sklad может быть булевым значением или строкой
        $this->togle = (bool) Auth::user()->seller->moy_sklad;
    }

    public function render()
    {
        return view('livewire.seller.moy-sklad-togle');
    }
}
