<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Coupone;
use Illuminate\Http\Request;

class CouponesController extends Controller
{
    public function coupones()
    {
        $coupones = Coupone::with('category')->orderBy('created_at', 'desc')->get();
        $categories = Category::orderBy('name')->get();
        return view('admin.pages.coupones', compact('coupones', 'categories'));
    }
    public function addcoupones(Request $request)
    {
        $validatedData = $request->validate([
            'code' => 'nullable|string|max:255',
            'percent' => 'required|numeric|min:0|max:100',
            'scope' => 'nullable|in:all,category',
            'category_id' => 'required_if:scope,category|exists:categories,id',
            'auto_apply' => 'nullable|boolean',
        ]);

        Coupone::create([
            'code' => $validatedData['code'],
            'percent' => $validatedData['percent'],
            'status' => true,
            'scope' => $validatedData['scope'],
            'category_id' => $validatedData['scope'] === 'category' ? $validatedData['category_id'] : null,
            'auto_apply' => $request->boolean('auto_apply', true),
        ]);

        return back()->with('success', 'Купон успешно добавлен!');
    }

    public function deletecoupones($id)
    {
        $coupon = Coupone::find($id);

        if ($coupon) {
            $coupon->delete();
            return back()->with('success', 'Купон успешно удален!');
        } else {
            return back()->with('error', 'Купон не найден.');
        }
    }
}
