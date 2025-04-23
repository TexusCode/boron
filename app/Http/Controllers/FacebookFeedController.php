<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class FacebookFeedController extends Controller
{
    public function index()
    {
        $products = Product::all();

        $xml = new \SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><rss/>');
        $xml->addAttribute('version', '2.0');
        $xml->addAttribute('xmlns:g', 'http://base.google.com/ns/1.0');

        $channel = $xml->addChild('channel');
        $channel->addChild('title', 'Product Feed');
        $channel->addChild('link', url('/facebook-feed'));
        $channel->addChild('description', 'Feed for Facebook Catalog');

        foreach ($products as $product) {
            if ($product->miniature) {
                $item = $channel->addChild('item');
                $item->addChild('g:id', $product->id, 'http://base.google.com/ns/1.0');
                $item->addChild('title', htmlspecialchars($product->title));
                $item->addChild('description', htmlspecialchars($product->description));
                $item->addChild('link', url('/details/' . $product->id));
                $item->addChild('g:price', number_format($product->price, 2, '.', '') . ' USD', 'http://base.google.com/ns/1.0');
                $item->addChild('g:image_link', url('/public/storage/' . $product->miniature), 'http://base.google.com/ns/1.0');

                $availability = $product->quantity > 0 ? 'in stock' : 'out of stock';
                $item->addChild('g:availability', $availability, 'http://base.google.com/ns/1.0');

                $item->addChild('g:condition', 'new', 'http://base.google.com/ns/1.0');
                $item->addChild('g:brand', 'Boron', 'http://base.google.com/ns/1.0');
            }
        }

        file_put_contents(public_path('facebook_feed.xml'), $xml->asXML());
        return back()->with('success', 'Каталог успешно создано!');
    }

}
