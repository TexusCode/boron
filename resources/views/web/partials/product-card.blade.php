            @php
                $finalPrice = $product->display_price;
                $hasDiscount = $product->total_discount_percent > 0;
                $formattedFinalPrice = rtrim(rtrim(number_format($finalPrice, 2, '.', ''), '0'), '.');
                $formattedOriginalPrice = rtrim(rtrim(number_format($product->price, 2, '.', ''), '0'), '.');
            @endphp
            <div class="p-1 bg-white border border-gray-200 shadow-sm rounded-xl dark:border-gray-700 dark:bg-gray-800">
                <div class="relative p-0 overflow-hidden rounded-lg">
                    <div class="aspect-w-1 aspect-h-1">
        @php
            $thumbPath = $product->miniature ? 'thumbs/' . ltrim($product->miniature, '/') : null;
            $imagePath = $product->miniature;
            if ($thumbPath && Storage::disk('public')->exists($thumbPath)) {
                $imagePath = $thumbPath;
            }
            $imageUrl = $imagePath ? asset('storage/' . $imagePath) : 'https://via.placeholder.com/300x300?text=No+Image';
        @endphp
                        <a href="{{ route('details',$product->id) }}">
                            <img class="object-cover object-center w-full h-full duration-150 hover:scale-110" src="{{ $imageUrl }}" alt="{{ $product->name }}" />
                        </a>
                    </div>
                    @livewire('web.add-to-favorite', ['id'=>$product->id])
                    @if($hasDiscount)
                    <span class="rounded-md text-xs font-bold px-1.5 absolute top-1 left-1 text-white bg-red-500">

                        -{{ $product->total_discount_percent }}%
                    </span>
                    @endif
                    <span class="absolute px-2 text-xs font-semibold text-white uppercase bg-green-500 rounded-md bottom-1 left-1">
                        Рассрочка
                    </span>
                </div>
                <div class="mt-1">
                    <a href="{{ route('details',$product->id) }}" class="text-xs font-semibold leading-tight text-gray-900 whitespace-normal hover:underline line-clamp-1">{{ $product->name }}</a>
                    <p class="my-2 text-lg font-bold leading-none text-primary-700">
                        <span>{{ $formattedFinalPrice }}c</span>
                        @if($hasDiscount)
                        <span class="text-base font-normal text-red-700 line-through">{{ $formattedOriginalPrice }}c</span>
                        @endif
                    </p>
                    <ul class="flex items-center gap-4">
                        @if($product->stock > 0)

                        <li class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-green-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h6l2 4m-8-4v8m0-8V6a1 1 0 0 0-1-1H4a1 1 0 0 0-1 1v9h2m8 0H9m4 0h2m4 0h2v-4m0 0h-5m3.5 5.5a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0Zm-10 0a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0Z" />
                            </svg>
                            <p class="text-sm font-medium text-green-500 dark:text-gray-400">Доставка: <span class="font-bold">
                                    @switch($product->delivery)
                                    @case(1)
                                    Сегодня
                                    @break
                                    @case(2)
                                    Завтра
                                    @break

                                    @default
                                    Через {{ $product->delivery }} дня
                                    @endswitch
                                </span></p>

                        </li>
                        @else
                        <li class="flex items-center gap-1 text-sm font-medium text-red-600">

                            <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 12c.263 0 .524-.06.767-.175a2 2 0 0 0 .65-.491c.186-.21.333-.46.433-.734.1-.274.15-.568.15-.864a2.4 2.4 0 0 0 .586 1.591c.375.422.884.659 1.414.659.53 0 1.04-.237 1.414-.659A2.4 2.4 0 0 0 12 9.736a2.4 2.4 0 0 0 .586 1.591c.375.422.884.659 1.414.659.53 0 1.04-.237 1.414-.659A2.4 2.4 0 0 0 16 9.736c0 .295.052.588.152.861s.248.521.434.73a2 2 0 0 0 .649.488 1.809 1.809 0 0 0 1.53 0 2.03 2.03 0 0 0 .65-.488c.185-.209.332-.457.433-.73.1-.273.152-.566.152-.861 0-.974-1.108-3.85-1.618-5.121A.983.983 0 0 0 17.466 4H6.456a.986.986 0 0 0-.93.645C5.045 5.962 4 8.905 4 9.736c.023.59.241 1.148.611 1.567.37.418.865.667 1.389.697Zm0 0c.328 0 .651-.091.94-.266A2.1 2.1 0 0 0 7.66 11h.681a2.1 2.1 0 0 0 .718.734c.29.175.613.266.942.266.328 0 .651-.091.94-.266.29-.174.537-.427.719-.734h.681a2.1 2.1 0 0 0 .719.734c.289.175.612.266.94.266.329 0 .652-.091.942-.266.29-.174.536-.427.718-.734h.681c.183.307.43.56.719.734.29.174.613.266.941.266a1.819 1.819 0 0 0 1.06-.351M6 12a1.766 1.766 0 0 1-1.163-.476M5 12v7a1 1 0 0 0 1 1h2v-5h3v5h7a1 1 0 0 0 1-1v-7m-5 3v2h2v-2h-2Z" />
                            </svg>
                            Нет в наличии

                        </li>
                        @endif
                    </ul>

                    <div class="flex items-center justify-between gap-1 mt-1">
                        @livewire('web.add-to-cart', ['id'=>$product->id])
                    </div>
                </div>
            </div>
