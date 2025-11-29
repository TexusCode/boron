<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;


class MiniatureController extends Controller
{
    public function imageoptomozer()
    {
        ini_set('max_execution_time', 20000);

        $products = Product::whereNotNull('miniature')->get();

        foreach ($products as $product) {
            $miniaturePath = $product->miniature;

            if (Storage::disk('public')->exists($miniaturePath)) {
                $image = Image::make(Storage::disk('public')->path($miniaturePath));
                $image->resize(200, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });

                $background = Image::canvas(200, 200, '#FFFFFF');
                $background->insert($image, 'center');

                $thumbPath = 'thumbs/' . ltrim($miniaturePath, '/');

                $directory = trim(dirname($thumbPath), '.');
                if ($directory) {
                    Storage::disk('public')->makeDirectory($directory);
                }

                $background->save(Storage::disk('public')->path($thumbPath));
            }
        }

        return back()->with('success', 'Миниатюры успешно созданы.');
    }
}
