@php
    $finalPrice = $product->display_price;
    $hasDiscount = $product->total_discount_percent > 0;
    $formattedFinalPrice = rtrim(rtrim(number_format($finalPrice, 2, '.', ''), '0'), '.');
    $formattedOriginalPrice = rtrim(rtrim(number_format($product->price, 2, '.', ''), '0'), '.');
    $thumbPath = $product->miniature ? 'thumbs/' . ltrim($product->miniature, '/') : null;
    $imagePath = $product->miniature;
    if ($thumbPath && Storage::disk('public')->exists($thumbPath)) {
        $imagePath = $thumbPath;
    }
    $imageUrl = $imagePath ? asset('storage/' . $imagePath) : 'https://via.placeholder.com/300x300?text=No+Image';

    $statusMap = [
        1 => ['label' => 'Активно', 'bg' => 'bg-emerald-100 text-emerald-600', 'dot' => 'bg-emerald-500'],
        0 => ['label' => 'Неактивно', 'bg' => 'bg-rose-100 text-rose-600', 'dot' => 'bg-rose-500'],
    ];
    $status = $statusMap[$product->status ? 1 : 0];
@endphp

<div class="group relative flex flex-col overflow-hidden rounded-3xl border border-gray-100 bg-white shadow-lg transition hover:-translate-y-1 hover:shadow-2xl">
    <div class="relative">
        <div class="aspect-[4/3] overflow-hidden">
            <img src="{{ $imageUrl }}" alt="{{ $product->name }}" class="h-full w-full object-cover transition duration-300 group-hover:scale-105" />
            <div class="absolute inset-0 bg-gradient-to-t from-black/40 via-black/10 to-transparent"></div>
        </div>

        <label class="absolute left-4 top-4 inline-flex items-center gap-2 rounded-full bg-white/90 px-3 py-1 text-xs font-semibold text-gray-600 shadow">
            <input type="checkbox" name="products[]" value="{{ $product->id }}" class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
            Выбрать
        </label>

        <span class="absolute right-4 top-4 inline-flex items-center gap-2 rounded-full px-3 py-1 text-xs font-semibold {{ $status['bg'] }}">
            <span class="h-1.5 w-1.5 rounded-full {{ $status['dot'] }}"></span>
            {{ $status['label'] }}
        </span>

        <a href="{{ route('edit-product-selle', $product->id) }}" class="absolute bottom-4 right-4 inline-flex items-center gap-2 rounded-full bg-white/90 px-3 py-1 text-xs font-semibold text-gray-700 shadow hover:bg-white">
            <svg class="h-4 w-4 text-indigo-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                <path fill-rule="evenodd" d="M11.32 6.176H5c-1.105 0-2 .949-2 2.118v10.588C3 20.052 3.895 21 5 21h11c1.105 0 2-.948 2-2.118v-7.75l-3.914 4.144A2.46 2.46 0 0 1 12.81 16l-2.681.568c-1.75.37-3.292-1.263-2.942-3.115l.536-2.839c.097-.512.335-.983.684-1.352l2.914-3.086Z" clip-rule="evenodd" />
                <path fill-rule="evenodd" d="M19.846 4.318a2.148 2.148 0 0 0-.437-.692 2.014 2.014 0 0 0-.654-.463 1.92 1.92 0 0 0-1.544 0 2.014 2.014 0 0 0-.654.463l-.546.578 2.852 3.02.546-.579a2.14 2.14 0 0 0 .437-.692 2.244 2.244 0 0 0 0-1.635ZM17.45 8.721 14.597 5.7 9.82 10.76a.54.54 0 0 0-.137.27l-.536 2.84c-.07.37.239.696.588.622l2.682-.567a.492.492 0 0 0 .255-.145l4.778-5.06Z" clip-rule="evenodd" />
            </svg>
            Редактировать
        </a>
    </div>

    <div class="flex flex-1 flex-col gap-3 p-5">
        <div class="flex items-center justify-between text-xs text-gray-500">
            <span>Код: {{ $product->code ?? '—' }}</span>
            <span>Склад: {{ $product->stock ?? '—' }}</span>
        </div>

        <a href="{{ route('details', $product->id) }}" class="text-lg font-semibold text-gray-900 line-clamp-2 hover:text-indigo-600">{{ $product->name }}</a>

        <div class="space-y-1 text-sm text-gray-500">
            @if($product->category)
                <p>Категория: <span class="font-semibold text-gray-900">{{ $product->category->name }}</span></p>
            @endif
            @if($product->subcategory)
                <p>Подкатегория: <span class="font-semibold text-gray-900">{{ $product->subcategory->name }}</span></p>
            @endif
        </div>

        <div>
            <p class="text-xs uppercase tracking-wide text-gray-400">Цена</p>
            <div class="flex items-baseline gap-2">
                <span class="text-2xl font-semibold text-gray-900">{{ $formattedFinalPrice }} c</span>
                @if($hasDiscount)
                    <span class="text-sm text-gray-400 line-through">{{ $formattedOriginalPrice }} c</span>
                    <span class="rounded-full bg-rose-100 px-2 py-0.5 text-xs font-semibold text-rose-600">-{{ $product->total_discount_percent }}%</span>
                @endif
            </div>
        </div>

        <div class="mt-auto flex items-center justify-between pt-3 text-xs text-gray-500">
            <span class="inline-flex items-center gap-2 rounded-full bg-indigo-50 px-3 py-1 font-semibold text-indigo-600">
                {{ $product->seller->store_name }}
            </span>
            <a href="{{ route('details', $product->id) }}" class="text-indigo-600 hover:underline">Смотреть</a>
        </div>
    </div>
</div>
