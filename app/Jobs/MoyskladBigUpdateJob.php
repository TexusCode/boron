<?php

namespace App\Jobs;

use App\Models\Seller;
use GuzzleHttp\Client;
use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Http;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class MoyskladBigUpdateJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $username;
    private $password;
    private $sellerId;

    /**
     * Create a new job instance.
     */
    public function __construct($username, $password, $sellerId)
    {
        $this->username = $username;
        $this->password = $password;
        $this->sellerId = $sellerId;
    }

    /**
     * Execute the job.
     */
public function handle(): void
    {
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
                break;
            }
        } while (count($products['rows']) == $limit);

        $seller = Seller::find($this->sellerId);

        foreach ($allProducts as $product) {
            $price = !empty($product['salePrices'])
                ? $product['salePrices'][0]['value'] / 100 ?? null
                : null;

            $pr = Product::where('moysklad_id', $product['id'])->first();

            if (!$pr) {
                $savep = Product::firstOrNew(['moysklad_id' => $product['id']]);
                $savep->seller_id = $seller->id;
                $savep->name = $product['name'] ?? null;
                $savep->description = $product['description'] ?? null;
                $savep->code = $product['code'] ?? rand(10000, 99999);
                $savep->stock = $product['stock'] ?? null;
                $savep->price = $price;

                $filename = null;
                $hasImage = false;

                if (isset($product['images']['meta']['href'])) {
                    $client = new Client([
                        'timeout' => 20000,
                        'connect_timeout' => 20000,
                    ]);

                    $imageResponse = $client->get(
                        $product['images']['meta']['href'],
                        [
                            'auth' => [$this->username, $this->password],
                            'headers' => ['Accept-Encoding' => 'gzip'],
                            'limit' => 1,
                        ]
                    );

                    $images = json_decode($imageResponse->getBody());
                    foreach ($images->rows as $image) {
                        $activeimage = $client->get($image->meta->downloadHref, [
                            'auth' => [$this->username, $this->password],
                            'headers' => ['Accept-Encoding' => 'gzip'],
                        ]);

                        $imageData = $activeimage->getBody()->getContents();
                        $filename = 'images/' . uniqid() . '_' . $image->filename;

                        Storage::disk('public')->put($filename, $imageData);
                        $hasImage = true;
                    }
                }

                $savep->miniature = $hasImage ? $filename : null;
                $savep->status = $hasImage;
                $savep->save();
            }
        }
    }
}
