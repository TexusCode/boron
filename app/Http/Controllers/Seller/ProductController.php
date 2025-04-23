<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\OtherPhoto;
use App\Models\Product;
use App\Models\Seller;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function products()
    {
        $seller = Auth::user()->seller->id;
        $products = Product::where('seller_id', $seller)->orderBy('created_at', 'desc')->paginate(100);
        $categories = Category::orderBy('created_at', 'desc')->get();
        $subcategories = SubCategory::orderBy('created_at', 'desc')->get();
        return view('seller.pages.products', compact('products', 'categories', 'subcategories'));
    }

    public function peendingproducts()
    {
        $seller = Auth::user()->seller->id;
        $products = Product::where('seller_id', $seller)->orderBy('created_at', 'desc')->where('status', false)->paginate(100);
        $categories = Category::orderBy('created_at', 'desc')->get();
        $subcategories = SubCategory::orderBy('created_at', 'desc')->get();
        return view('seller.pages.products', compact('products', 'categories', 'subcategories'));
    }
    public function productsnotstock()
    {
        $seller = Auth::user()->seller->id;
        $products = Product::where('seller_id', $seller)->orderBy('created_at', 'desc')->where('stock', 0)->paginate(100);
        $categories = Category::orderBy('created_at', 'desc')->get();
        $subcategories = SubCategory::orderBy('created_at', 'desc')->get();
        return view('seller.pages.products', compact('products', 'categories', 'subcategories'));
    }
    public function addproduct()
    {
        $categories = Category::orderBy('created_at', 'desc')->get();
        $subcategories = SubCategory::orderBy('created_at', 'desc')->get();
        $sellers = Seller::orderBy('created_at', 'desc')->get();
        return view('seller.pages.add-product', compact('categories', 'subcategories', 'sellers'));
    }

    public function addproductpost(Request $request)
    {
        $user = Auth::user();
        $product = new Product();
        $product->name = $request->name;
        $product->description = $request->description;
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
        $product->seller_id = $user->seller->id;
        $product->status = false;
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
        return view('seller.pages.edit-product', compact('product', 'categories', 'subcategories', 'sellers'));
    }
    public function editproductpost(Request $request, $id)
    {
        $user = Auth::user();
        // Find the product by ID
        $product = Product::findOrFail($id);

        // Update product properties
        $product->name = $request->name;
        $product->description = $request->description;
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
        $product->seller_id = $user->seller->id;; // Change from 'seller' to 'seller_id'
        $product->status = false; // You might want to check if you need this line
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
        $sellerId = Auth::user()->seller->id;

        // Handle delete action
        if ($request->action === 'delete' && $request->products) {
            Product::where('seller_id', $sellerId)
                ->whereIn('id', $request->products)
                ->delete();
        }

        // Start building the product query with seller-specific filtering
        $query = Product::where('seller_id', $sellerId);

        // Apply search filter if present
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('code', 'like', '%' . $request->search . '%');
            });
        }

        // Apply status filter if present
        if ($request->has('status')) {
            $status = $request->status === '1';
            $query->where('status', $status);
        }

        // Apply category and subcategory filters if no specific products are selected
        if (!$request->products) {
            if ($request->filled('category')) {
                $query->where('category_id', $request->category);
            }
            if ($request->filled('subcategory')) {
                $query->where('subcategory_id', $request->subcategory);
            }
        } else {
            // Update category and subcategory for selected products only
            if ($request->filled('category')) {
                Product::where('seller_id', $sellerId)
                    ->whereIn('id', $request->products)
                    ->update(['category_id' => $request->category]);
            }

            if ($request->filled('subcategory')) {
                Product::where('seller_id', $sellerId)
                    ->whereIn('id', $request->products)
                    ->update(['subcategory_id' => $request->subcategory]);
            }
        }

        // Get paginated products after applying filters
        $products = $query->orderBy('created_at', 'desc')->paginate(100);

        // Retrieve categories and subcategories
        $categories = Category::orderBy('created_at', 'desc')->get();
        $subcategories = SubCategory::orderBy('created_at', 'desc')->get();

        // Return the view with filtered products and lists of categories and subcategories
        return view('seller.pages.products', compact('products', 'categories', 'subcategories'));
    }
}
