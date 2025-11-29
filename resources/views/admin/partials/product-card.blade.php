@php
    $finalPrice = $product->display_price;
    $hasDiscount = $product->total_discount_percent > 0;
    $formattedFinalPrice = rtrim(rtrim(number_format($finalPrice, 2, '.', ''), '0'), '.');
    $formattedOriginalPrice = rtrim(rtrim(number_format($product->price, 2, '.', ''), '0'), '.');
@endphp
<div class="p-1 bg-white border border-gray-200 shadow-sm rounded-xl dark:border-gray-700 dark:bg-gray-800">
    <div class="relative p-0 overflow-hidden rounded-lg">
        @php
            $thumbPath = $product->miniature ? 'thumbs/' . ltrim($product->miniature, '/') : null;
            $imagePath = $product->miniature;
            if ($thumbPath && Storage::disk('public')->exists($thumbPath)) {
                $imagePath = $thumbPath;
            }
            $imageUrl = $imagePath ? asset('storage/' . $imagePath) : 'https://via.placeholder.com/300x300?text=No+Image';
        @endphp
        <div class="aspect-w-1 aspect-h-1">
            <a href="{{ route('details',$product->id) }}">
                <img class="object-cover object-center w-full h-full duration-150 hover:scale-110" src="{{ $imageUrl }}" alt="{{ $product->name }}" />
            </a>
        </div>
        <span class="absolute top-1 left-2">
            <input type="checkbox" name="products[]" value="{{ $product->id }}">
        </span>
        <span class="absolute top-1 right-2">
            <a href="{{ route('edit-product',$product->id) }}">
                <svg class="w-6 h-6 text-gray-800 hover:text-blue-600" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                    <path fill-rule="evenodd" d="M11.32 6.176H5c-1.105 0-2 .949-2 2.118v10.588C3 20.052 3.895 21 5 21h11c1.105 0 2-.948 2-2.118v-7.75l-3.914 4.144A2.46 2.46 0 0 1 12.81 16l-2.681.568c-1.75.37-3.292-1.263-2.942-3.115l.536-2.839c.097-.512.335-.983.684-1.352l2.914-3.086Z" clip-rule="evenodd" />
                    <path fill-rule="evenodd" d="M19.846 4.318a2.148 2.148 0 0 0-.437-.692 2.014 2.014 0 0 0-.654-.463 1.92 1.92 0 0 0-1.544 0 2.014 2.014 0 0 0-.654.463l-.546.578 2.852 3.02.546-.579a2.14 2.14 0 0 0 .437-.692 2.244 2.244 0 0 0 0-1.635ZM17.45 8.721 14.597 5.7 9.82 10.76a.54.54 0 0 0-.137.27l-.536 2.84c-.07.37.239.696.588.622l2.682-.567a.492.492 0 0 0 .255-.145l4.778-5.06Z" clip-rule="evenodd" />
                </svg>
            </a>
        </span>
    </div>
    <div class="mt-1">
        <a href="{{ route('details',$product->id) }}" class="text-base font-semibold leading-tight text-gray-900 whitespace-normal hover:underline dark:text-white line-clamp-1">{{ $product->name }}</a>
        @if($product->category)
        <p class="text-sm leading-tight text-gray-900 whitespace-normal hover:underline dark:text-white line-clamp-1">Категория: <span class="font-bold">{{ $product->category->name }} </span></p>
        @endif
        @if($product->subcategory)
        <p class="text-sm leading-tight text-gray-900 whitespace-normal hover:underline dark:text-white line-clamp-1">Подкатегория: <span class="font-bold">{{ $product->subcategory->name }}</span></p>
        @endif
        <p class="text-sm leading-tight text-gray-900 whitespace-normal hover:underline dark:text-white line-clamp-1">Магазин: <span class="font-bold text-blue-600">{{ $product->seller->store_name }}</span></p>


        <p class="my-2 text-lg font-bold leading-none text-primary-700">
            <span>{{ $formattedFinalPrice }}c</span>
            @if($hasDiscount)
            <span class="text-base font-normal text-red-700 line-through">{{ $formattedOriginalPrice }}c</span>
            <span class="ml-1 text-xs font-semibold text-red-500">-{{ $product->total_discount_percent }}%</span>
            @endif
        </p>
        <p class="text-sm leading-tight text-gray-900 whitespace-normal hover:underline dark:text-white line-clamp-1">Статус:
            @switch($product->status)
            @case(1)
            <span class="font-bold text-green-500">Активно</span>

            @break

            @default
            <span class="font-bold text-red-500">Неактивно</span>




            @endswitch
        </p>

    </div>

</div>
