<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;

class SliderController extends Controller
{
    public function sliders()
    {
        $sliders = Slider::all();
        return view('admin.pages.sliders', compact('sliders'));
    }
    public function slideradd(Request $request)
    {
        $request->validate([
            'image' => 'required|image',
            'link' => 'required|url',
        ]);

        // Сохраняем изображение в папку storage/app/public/sliders
        $imagePath = $request->file('image')->store('sliders', 'public');

        // Создаем новый слайдер с сохраненным путем к изображению
        Slider::create([
            'image' => $imagePath,
            'link' => $request->link,
        ]);

        return back()->with('success', 'Успешно добавлено!');
    }

    public function sliderdel($id)
    {
        Slider::destroy($id);
        return back()->with('success','Успешно удалено!');
    }

}
