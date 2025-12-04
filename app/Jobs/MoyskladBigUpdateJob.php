<?php

namespace App\Jobs;

use App\Models\Seller;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Http;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class MoyskladBigUpdateJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $username;
    private $password;
    private $sellerId;

    public function __construct($username, $password, $sellerId)
    {
        $this->username = $username;
        $this->password = $password;
        $this->sellerId = $sellerId;
    }

    public function handle(): void
    {
        $seller = Seller::find($this->sellerId);

        if (!$seller) {
            return;
        }

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

            if (!$response->successful()) {
                break;
            }

            $products = $response->json();
            $rows = $products['rows'] ?? [];

            foreach ($rows as $product) {
                MoyskladProductSyncJob::dispatch(
                    $this->username,
                    $this->password,
                    $seller->id,
                    $product
                );
            }

            $offset += $limit;
        } while (count($rows) === $limit);
    }
}
