<?php

namespace App\Livewire\Web;

use App\Models\Favorite;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class AddToFavorite extends Component
{
    public $id;
    public $isfavorite = false;
    public $favorite;

    public function mount($id)
    {
        $this->id = $id;
        $this->favorite = Favorite::where('user_id', Auth::id())->where('product_id', $this->id)->first();
        $this->isfavorite = $this->favorite ? true : false;
    }

    public function addTofavorite()
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
        return view('livewire.web.add-to-favorite');
    }
}
