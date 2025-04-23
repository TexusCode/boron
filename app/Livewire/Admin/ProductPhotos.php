<?php

namespace App\Livewire\Admin;

use App\Models\OtherPhoto;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class ProductPhotos extends Component
{
    public $id;
    public $product;
    public function mount($id)
    {
        $this->id = $id;
        $this->photoupdated();
    }
    public function photoupdated()
    {
        $this->product = Product::find($this->id);
    }
    public function remove($id)
    {
        // Find the photo by ID
        $photo = OtherPhoto::findOrFail($id);

        // Delete the photo from storage if necessary
        Storage::disk('public')->delete($photo->photo);

        // Delete the photo record from the database
        $photo->delete();

        // return back()->with('success', 'Фото успешно удалено');
    }

    public function render()
    {
        return view('livewire.admin.product-photos');
    }
}
