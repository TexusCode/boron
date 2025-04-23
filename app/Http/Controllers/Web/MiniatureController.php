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

        // Получаем все продукты с миниатюрами
        $products = Product::whereNotNull('miniature')->get();

        foreach ($products as $product) {
            $miniaturePath = $product->miniature;

            if (Storage::disk('public')->exists($miniaturePath)) {
                // Чтение изображения
                $image = Image::make(Storage::disk('public')->path($miniaturePath)); // Используем disk('public') для корректного пути
                // dd($image); // Вывод изображения для отладки

                // Изменение ширины на 300 пикселей (с сохранением пропорций)
                $image->resize(200, null, function ($constraint) {
                    $constraint->aspectRatio();  // Сохраняем пропорции
                    $constraint->upsize();       // Не увеличиваем изображение
                });

                // Теперь получаем размеры изображения после изменения
                $width = $image->width();
                $height = $image->height();

                // Находим минимальный размер, чтобы сделать изображение квадратным
                $size = min($width, $height);

                // Обрезаем изображение в центр
                // $image->crop(
                //     $size, // ширина после обрезки
                //     $size, // высота после обрезки
                //     (int)(($width - $size) / 2), // сдвиг по оси X
                //     (int)(($height - $size) / 2) // сдвиг по оси Y
                // );

                // Добавление текста "boron.tj" в левом нижнем углу
                // $image->text(
                //     'BORON.TJ',
                //     10, // Отступ от левого края
                //     $image->height() - 10, // Отступ от нижнего края
                //     function ($font) {
                //         $font->file(public_path('font/grotesqueno9t.ttf')); // Путь к шрифту
                //         $font->size(5); // Размер текста
                //         $font->color('#000000'); // Цвет текста
                //         $font->align('left');
                //         $font->valign('bottom');
                //     }
                // );
                $background = Image::canvas(200, 200, '#FFFFFF');
                $background->insert($image, 'center');
                // Путь для сохранения в папку "thumbs"
                $zumbsPath = 'thumbs/images/' . basename($miniaturePath);

                // Сохранение изображения
                $background->save(Storage::disk('public')->path($zumbsPath));  // Сохраняем в 'public/'
            }

        }

        // Возвращаемся назад после обработки всех изображений
        return back();
    }

}
