<?php

namespace App\Livewire\Admin;

use App\Models\Category;
use App\Models\SubCategory;
use Livewire\Component;

class Action extends Component
{
    public $categories;
    public $subcategories;
    public $selectedCategory;
    public $selectedSubcategory;
    public function mount() {
        $this->categories = Category::all();
    }
    public function updatedSelectedCategory() {
        // dd($this->selectedCategory);
        $this->subcategories = SubCategory::where('category_id', $this->selectedCategory)->get();
    }
    public function render()
    {
        return view('livewire.admin.action');
    }
}
