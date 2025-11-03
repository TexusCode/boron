<?php

namespace App\Http\Controllers\Seller;

use App\Models\Seller;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Jobs\MoyskladBigUpdateJob;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use App\Models\Product as ModelsProduct;

class MoyskladController extends Controller
{
    // private $username = 'admin@boronstore';
    // private $password = '933604040a';
    private $baseUrl = 'https://api.moysklad.ru/api/remap/1.2/';
    private $username;
    private $password;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->username = Auth::user()->seller->moysklad_login;
            $this->password = Auth::user()->seller->moysklad_password;
            return $next($request);
        });
    }


public function moyskladbigupdate()
{
    $user = Auth::user();
    $seller = $user->seller;

    MoyskladBigUpdateJob::dispatch(
        $seller->moysklad_login,
        $seller->moysklad_password,
        $seller->id
    );

    return back()->with('success', 'Загрузка товаров запущена в фоне.');
}

    public function settings()
    {
        $seller = auth()->user()->seller;
        return view('seller.pages.settings', compact('seller'));
    }
    public function moyskladsettings()
    {

        return view('seller.pages.moy-sklad');
    }

    public function updateSettings(Request $request)
    {
        $seller = auth()->user()->seller;

        if ($request->hasFile('store_logo')) {
            $logoPath = $request->file('store_logo')->store('seller', 'public');
            $seller->logo = $logoPath;
        }

        $seller->store_name = $request->store_name;
        $seller->store_phone = $request->store_phone;
        $seller->description = $request->store_description;
        if ($request->enable_moysklad) {
            $seller->moy_sklad = true;
        } else {
            $seller->moy_sklad = false;
        }
        $seller->moysklad_login = $request->moysklad_login;
        $seller->moysklad_password = $request->moysklad_password;
        $seller->save();

        return redirect()->route('seller.settings')->with('success', 'Настройки успешно обновлены.');
    }

    public function updateStockQuantities()
    {
        ini_set('max_execution_time', 20000);
        $user_id = Auth::id();
        $seller = Seller::where('user_id', $user_id)->first();

        $allProducts = [];
        $limit = 1000;
        $offset = 0;
        $baseUrl = 'https://api.moysklad.ru/api/remap/1.2/';
        do {
            $response = Http::withBasicAuth($this->username, $this->password)
                ->withHeaders([
                    'Accept-Encoding' => 'gzip',
                    'Content-Type' => 'application/json',
                ])
                ->get($baseUrl . 'entity/assortment', [
                    'limit' => $limit,
                    'offset' => $offset,
                ]);

            if ($response->successful()) {
                $products = $response->json();

                $allProducts = array_merge($allProducts, $products['rows']);

                $offset += $limit;
            } else {
                // dd('Ошибка: ' . $response->status(), $response->body());
            }
        } while (count($products['rows']) == $limit);

        $counter = count($allProducts);
        $count = 0;
        foreach ($allProducts as $product) {
            // Находим продукт в базе данных по seller_id и moysklad_id
            $savep = ModelsProduct::where('seller_id', $seller->id)
                ->where('moysklad_id', $product['id'])
                ->first();

            if ($savep) {
                // Обновляем только количество
                $savep->stock = $product['stock'] ?? null;
                $savep->save();
                $count++;
            }
        }

        return back()->with('success', 'Успешно обновлено количество товаров: ' . $count);
    }

}
