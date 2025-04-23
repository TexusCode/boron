<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Coupone;
use Illuminate\Http\Request;

class CouponesController extends Controller
{
    public function coupones()
    {
        $coupones = Coupone::orderBy('created_at', 'desc')->get();
        return view('admin.pages.coupones', compact('coupones'));
    }
    public function addcoupones(Request $request)
    {
        $validatedData = $request->validate([
            'code' => 'required|string|max:255',
            'percent' => 'required|numeric|min:0|max:100',
        ]);

        Coupone::create([
            'code' => $validatedData['code'],
            'percent' => $validatedData['percent'],
            'status' => true,
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
