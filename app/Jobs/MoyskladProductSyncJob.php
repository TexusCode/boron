<?php

namespace App\Jobs;

use GuzzleHttp\Client;
use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class MoyskladProductSyncJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $username;
    private $password;
    private $sellerId;
    private $product;

    public function __construct($username, $password, $sellerId, array $product)
    {
        $this->username = $username;
        $this->password = $password;
        $this->sellerId = $sellerId;
        $this->product = $product;
    }

    public function handle(): void
    {
        if (empty($this->sellerId) || empty($this->product['id'])) {
            return;
        }

        $productData = $this->product;

        $price = !empty($productData['salePrices'])
            ? $productData['salePrices'][0]['value'] / 100 ?? null
            : null;

        $savep = Product::firstOrNew([
            'moysklad_id' => $productData['id'],
            'seller_id' => $this->sellerId,
        ]);

        $savep->name = $productData['name'] ?? $savep->name;
        $savep->description = $productData['description'] ?? $savep->description;
        $savep->code = $productData['code'] ?? $savep->code ?? rand(10000, 99999);
        $savep->stock = $productData['stock'] ?? $savep->stock;
        $savep->price = $price ?? $savep->price;

        $filename = null;
        $hasImage = false;

        if (isset($productData['images']['meta']['href'])) {
            $client = new Client([
                'timeout' => 20000,
                'connect_timeout' => 20000,
            ]);

            $imageResponse = $client->get(
                $productData['images']['meta']['href'],
                [
                    'auth' => [$this->username, $this->password],
                    'headers' => ['Accept-Encoding' => 'gzip'],
                    'limit' => 1,
                ]
            );

            $images = json_decode($imageResponse->getBody());
            if (!empty($images->rows)) {
                foreach ($images->rows as $image) {
                    $activeimage = $client->get($image->meta->downloadHref, [
                        'auth' => [$this->username, $this->password],
                        'headers' => ['Accept-Encoding' => 'gzip'],
                    ]);

                    $imageData = $activeimage->getBody()->getContents();
                    $filename = 'images/' . uniqid() . '_' . $image->filename;

                    Storage::disk('public')->put($filename, $imageData);
                    $hasImage = true;
                    break;
                }
            }
        }

        if ($hasImage) {
            $savep->miniature = $filename;
        }

        if (!$savep->miniature) {
            $savep->status = $hasImage ? true : false;
        } else {
            $savep->status = true;
        }

        $savep->save();
    }
}
