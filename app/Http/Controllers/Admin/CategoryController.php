<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
class CategoryController extends Controller
{
    //Category
    public function categories($id = null)
    {
        $category = $id ? Category::find($id) : null;
        $categories = Category::all();
        return view('admin.pages.categories', compact('categories', 'category'));
    }

    public function addcategory(Request $request, $id = null)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'photo' => 'nullable|image|max:2048', // Проверка файла
        ]);

        // Находим или создаём категорию
        $category = Category::updateOrCreate(
            ['id' => $id], // Поиск по ID
            ['name' => $data['name']]
        );

        // Если загружено новое фото
        if ($request->hasFile('photo')) {
            // Удаляем старое изображение, если оно существует
            if ($category->photo && Storage::exists('public/' . $category->photo)) {
                Storage::delete('public/' . $category->photo);
            }

            // Загружаем файл изображения
            $image = $request->file('photo');

            // Сжимаем изображение до ширины 100 пикселей, сохраняя пропорции
            $img = Image::make($image)->resize(100, null, function ($constraint) {
                    $constraint->aspectRatio(); // Сохраняем пропорции
                    $constraint->upsize(); // Не увеличиваем изображение, если оно меньше
                });

            // Сохраняем изображение в папку 'categories' в хранилище public
            $path = 'categories/' . uniqid() . '.jpg'; // Генерация уникального имени для файла
            $img->save(storage_path('app/public/' . $path)); // Сохраняем файл

            // Сохраняем путь к изображению в базе данных
            $category->photo = $path;
            $category->save();
        }


        return redirect()->route('categories')->with('success', 'Категория успешно сохранена');
    }


    public function deletecategory($id)
    {
        // Retrieve products associated with the category
        $products = Product::where('category_id', $id)->get();

        // Set category_id to null for each product
        foreach ($products as $product) {
            $product->category_id = null;
            $product->save();
        }

        // Delete the category
        Category::findOrFail($id)->delete();

        return back();
    }

    public function deletesubcategory($id)
    {
        // Retrieve products associated with the category
        $products = Product::where('subcategory_id', $id)->get();

        // Set category_id to null for each product
        foreach ($products as $product) {
            $product->subcategory_id = null;
            $product->save();
        }

        // Delete the category
        SubCategory::findOrFail($id)->delete();
        return back();
    }
    public function homecategory(Request $request, $id)
    {
        $category = Category::find($id);
        $category->ishome = !$category->ishome;
        $category->sort = $request->sort;
        $category->save();

        return back();
    }

    //SubCategory
    public function subcategories($id = null)
    {
        $subcategories = SubCategory::orderBy('created_at', 'desc')->get();
        $categories = Category::orderBy('created_at', 'desc')->get();
        $subcategory = $id ? SubCategory::find($id) : null;
        return view('admin.pages.subcategories', compact('subcategories', 'categories', 'subcategory'));
    }

    public function addsubcategory(Request $request, $id = null)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|string|max:255',
        ]);

        $subcategory = SubCategory::updateOrCreate(
            ['id' => $id], // Условие поиска
            [
                'name' => $data['name'],
                'category_id' => $data['category_id'],
            ]
        );

        return redirect()->route('subcategories')->with('success', 'Подкатегория успешно сохранена');
    }

}
