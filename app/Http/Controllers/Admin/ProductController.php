<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\OtherPhoto;
use App\Models\Product;
use App\Models\Seller;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function products()
    {
        $products = Product::orderBy('created_at', 'desc')->paginate(100);
        $categories = Category::orderBy('created_at', 'desc')->get();
        $subcategories = SubCategory::orderBy('created_at', 'desc')->get();
        return view('admin.pages.products', compact('products', 'categories', 'subcategories'));
    }

    public function peendingproducts()
    {
        $products = Product::orderBy('created_at', 'desc')->where('status', false)->paginate(100);
        $categories = Category::orderBy('created_at', 'desc')->get();
        $subcategories = SubCategory::orderBy('created_at', 'desc')->get();
        return view('admin.pages.products', compact('products', 'categories', 'subcategories'));
    }
    public function productsnotstock()
    {
        $products = Product::orderBy('created_at', 'desc')->where('stock', 0)->paginate(100);
        $categories = Category::orderBy('created_at', 'desc')->get();
        $subcategories = SubCategory::orderBy('created_at', 'desc')->get();
        return view('admin.pages.products', compact('products', 'categories', 'subcategories'));
    }
    public function addproduct()
    {
        $categories = Category::orderBy('created_at', 'desc')->get();
        $subcategories = SubCategory::orderBy('created_at', 'desc')->get();
        $sellers = Seller::orderBy('created_at', 'desc')->get();
        return view('admin.pages.add-product', compact('categories', 'subcategories', 'sellers'));
    }

    public function addproductpost(Request $request)
    {
        $product = new Product();
        $product->name = $request->name;
        $product->description = $request->filled('description') ? $request->description : null;
        $product->code = $request->code;
        $product->stock = $request->stock;
        $product->price = $request->price;
        $product->discount = $request->discount;
        $product->delivery = $request->delivery;

        if ($request->hasFile('miniature')) {
            $path = $request->file('miniature')->store('products', 'public');
            $product->miniature = $path;
        }

        $product->category_id = $request->category_id;
        $product->subcategory_id = $request->subcategory_id;
        $product->seller_id = $request->seller;
        $product->status = true;
        $product->save();

        if ($request->hasFile('otherphotos')) {
            foreach ($request->file('otherphotos') as $photo) {
                $path = $photo->store('products/otherphotos', 'public');
                $otherphoto = new OtherPhoto();
                $otherphoto->photo = $path;
                $otherphoto->product_id = $product->id;
                $otherphoto->save();
            }
        }
        return back()->with('success', 'Товар успешно добавлено');
    }

    public function editproduct(Request $request, $id)
    {
        // Find the product by ID
        $product = Product::findOrFail($id);
        $categories = Category::orderBy('created_at', 'desc')->get();
        $subcategories = SubCategory::orderBy('created_at', 'desc')->get();
        $sellers = Seller::orderBy('created_at', 'desc')->get();
        return view('admin.pages.edit-product', compact('product', 'categories', 'subcategories', 'sellers'));
    }
    public function editproductpost(Request $request, $id)
    {
        // Find the product by ID
        $product = Product::findOrFail($id);

        // Update product properties
        $product->name = $request->name;
        $product->description = $request->filled('description') ? $request->description : null;
        $product->code = $request->code;
        $product->stock = $request->stock;
        $product->price = $request->price;
        $product->discount = $request->discount;
        $product->delivery = $request->delivery;

        // Update miniature if a new file is uploaded
        if ($request->hasFile('miniature')) {
            // Delete old miniature if needed (optional)
            // Storage::disk('public')->delete($product->miniature);

            $path = $request->file('miniature')->store('products', 'public');
            $product->miniature = $path;
        }

        // Update category, subcategory, and seller
        $product->category_id = $request->category_id;
        $product->subcategory_id = $request->subcategory_id;
        // $product->seller_id = $request->seller;
        $product->status = true; // You might want to check if you need this line
        $product->save();

        // Handle additional photos
        if ($request->hasFile('otherphotos')) {
            foreach ($request->file('otherphotos') as $photo) {
                $path = $photo->store('products/otherphotos', 'public');
                $otherphoto = new OtherPhoto();
                $otherphoto->photo = $path;
                $otherphoto->product_id = $product->id;
                $otherphoto->save();
            }
        }

        return back()->with('success', 'Товар успешно обновлён');
    }



    public function productsUpdate(Request $request)
    {
        $query = Product::query();

        if ($request->products) {
            if ($request->action === 'delete') {
                Product::whereIn('id', $request->products)->delete();
            }

            if ($request->action === 'activate') {
                Product::whereIn('id', $request->products)->update(['status' => true]);
            }

            if ($request->action === 'deactivate') {
                Product::whereIn('id', $request->products)->update(['status' => false]);
            }

            if ($request->filled('category')) {
                Product::whereIn('id', $request->products)->update(['category_id' => $request->category]);
            }

            if ($request->filled('subcategory')) {
                Product::whereIn('id', $request->products)->update(['subcategory_id' => $request->subcategory]);
            }
        } else {
            // Apply filters for category and subcategory if no specific products are provided
            if ($request->filled('category')) {
                $query->where('category_id', $request->category);
            }

            if ($request->filled('subcategory')) {
                $query->where('subcategory_id', $request->subcategory);
            }
        }

        // Apply search filter
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('code', 'like', '%' . $request->search . '%');
            });
        }

        // Apply status filter
        if ($request->filled('status')) {
            $status = $request->status === '1';
            $query->where('status', $status);
        }

        // Execute the query with pagination and retrieve other data
        $products = $query->orderBy('created_at', 'desc')->paginate(100);
        $categories = Category::orderBy('created_at', 'desc')->get();
        $subcategories = SubCategory::orderBy('created_at', 'desc')->get();
        $sellers = Seller::orderBy('created_at', 'desc')->get();

        return view('admin.pages.products', compact('products', 'sellers', 'subcategories', 'categories'));
    }
}
