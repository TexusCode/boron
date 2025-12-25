<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\SubCategory;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function products(Request $request)
    {
        return $this->filteredProducts($request);
    }

    public function peendingproducts(Request $request)
    {
        $request->merge(['status' => 'pending']);
        return $this->filteredProducts($request);
    }

    public function productsnotstock(Request $request)
    {
        $request->merge(['stock' => '0']);
        return $this->filteredProducts($request);
    }

    private function filteredProducts(Request $request)
    {
        $query = Product::query();

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        if ($request->filled('subcategory')) {
            $query->where('subcategory_id', $request->subcategory);
        }

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('code', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->input('status') === 'pending') {
            $query->where('status', false);
        }

        if ($request->input('stock') === '0') {
            $query->where('stock', 0);
        }

        $products = $query->orderBy('created_at', 'desc')->paginate(100)->withQueryString();
        $categories = Category::orderBy('created_at', 'desc')->get();
        $subcategories = SubCategory::orderBy('created_at', 'desc')->get();

        return view('manager.pages.products', compact('products', 'categories', 'subcategories'));
    }
}
