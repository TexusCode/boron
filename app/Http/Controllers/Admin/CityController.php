<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\City;
use Illuminate\Http\Request;

class CityController extends Controller
{
    public function cities()
    {
        $cities = City::all();
        return view('admin.pages.cities', compact('cities'));
    }

    public function cityadd(Request $request)
    {
        $validatedData = $request->validate([
            'city' => 'required|string|max:255',
        ]);

        City::create([
            'name' => $validatedData['city'],
        ]);

        return back()->with('success', 'Город успешно добавлен!');
    }

    public function cityrdel($id)
    {
        $coupon = City::find($id);

        if ($coupon) {
            $coupon->delete();
            return back()->with('success', 'Город успешно удален!');
        } else {
            return back()->with('error', 'Город не найден.');
        }
    }
}
