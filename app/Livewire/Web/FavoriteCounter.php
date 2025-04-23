<?php

namespace App\Livewire\Web;

use App\Models\Favorite;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class FavoriteCounter extends Component
{
    public $count = 0; // Initialize the count property

    protected $listeners = ['updatedFavoriteCount' => 'favoriteCountUpdated'];

    public function mount()
    {
        $this->favoriteCountUpdated(); // Call the method to set the initial count
    }

    public function favoriteCountUpdated()
    {
        $this->count = Favorite::where('user_id', Auth::id())->count(); // Update the count based on the user's cart
    }
    public function render()
    {
        return view('livewire.web.favorite-counter');
    }
}
