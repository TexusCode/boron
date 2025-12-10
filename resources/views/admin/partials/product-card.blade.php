@php
    $finalPrice = $product->display_price;
    $hasDiscount = $product->total_discount_percent > 0;
    $formattedFinalPrice = rtrim(rtrim(number_format($finalPrice, 2, '.', ''), '0'), '.');
    $formattedOriginalPrice = rtrim(rtrim(number_format($product->price, 2, '.', ''), '0'), '.');
    $showSelection = $showSelection ?? true;
    $statusBadge = $product->status
        ? 'bg-emerald-50 text-emerald-700 ring-emerald-200'
        : 'bg-rose-50 text-rose-700 ring-rose-200';
    $thumbPath = $product->miniature ? 'thumbs/' . ltrim($product->miniature, '/') : null;
    $imagePath = $product->miniature;
    if ($thumbPath && Storage::disk('public')->exists($thumbPath)) {
        $imagePath = $thumbPath;
    }
    $imageUrl = $imagePath
        ? asset('storage/' . $imagePath)
        : asset('images/placeholders/product-empty.svg');
@endphp
<div class="group relative flex flex-col rounded-3xl border border-gray-100 bg-white p-3 text-sm shadow-sm transition hover:-translate-y-1 hover:shadow-xl">
    <div class="relative overflow-hidden rounded-2xl bg-gray-100">
        <img src="{{ $imageUrl }}" alt="{{ $product->name }}" class="h-48 w-full object-cover transition duration-300 group-hover:scale-105">
        <div class="absolute inset-x-0 top-3 flex items-center justify-between px-3 text-xs font-semibold">
            @if ($showSelection)
                <label class="inline-flex items-center gap-2 rounded-full bg-white/90 px-3 py-1 shadow-sm">
                    <input type="checkbox" name="products[]" value="{{ $product->id }}" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                    Выбрать
                </label>
            @else
                <span class="rounded-full bg-white/80 px-3 py-1 text-gray-500">ID: {{ $product->id }}</span>
            @endif
            <span class="inline-flex items-center rounded-full px-3 py-1 ring-1 {{ $statusBadge }}">
                {{ $product->status ? 'Активно' : 'Неактивно' }}
            </span>
        </div>
        <div class="absolute bottom-3 right-3 flex gap-2">
            <a href="{{ route('edit-product', $product->id) }}" class="inline-flex h-10 w-10 items-center justify-center rounded-2xl bg-white/90 text-gray-800 shadow hover:bg-indigo-600 hover:text-white">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487a2.085 2.085 0 0 1 2.95 2.95L9.75 17.5 6 18l.5-3.75z" />
                </svg>
            </a>
            <a href="{{ route('details', $product->id) }}" class="inline-flex h-10 w-10 items-center justify-center rounded-2xl bg-white/90 text-gray-800 shadow hover:bg-indigo-600 hover:text-white">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12s3.75-7.5 9.75-7.5S21.75 12 21.75 12s-3.75 7.5-9.75 7.5S2.25 12 2.25 12z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6z" />
                </svg>
            </a>
        </div>
    </div>

    <div class="mt-4 flex flex-1 flex-col gap-2">
        <div>
            <a href="{{ route('details', $product->id) }}" class="line-clamp-2 text-base font-semibold text-gray-900 hover:text-indigo-600">
                {{ $product->name }}
            </a>
            <p class="text-xs uppercase tracking-wide text-gray-400">#{{ $product->code }}</p>
        </div>
        <div class="text-xs text-gray-500">
            @if ($product->category)
                <p>Категория: <span class="font-semibold text-gray-900">{{ $product->category->name }}</span></p>
            @endif
            @if ($product->subcategory)
                <p>Подкатегория: <span class="font-semibold text-gray-900">{{ $product->subcategory->name }}</span></p>
            @endif
            <p>Магазин: <span class="font-semibold text-indigo-600">{{ $product->seller->store_name }}</span></p>
        </div>
        <div class="flex items-baseline gap-2 text-gray-900">
            <span class="text-xl font-semibold">{{ $formattedFinalPrice }} c</span>
            @if ($hasDiscount)
                <span class="text-sm font-medium text-rose-500 line-through">{{ $formattedOriginalPrice }} c</span>
                <span class="rounded-full bg-rose-50 px-2 py-0.5 text-xs font-semibold text-rose-500">-{{ $product->total_discount_percent }}%</span>
            @endif
        </div>
        <div class="mt-auto flex items-center justify-between text-xs text-gray-500">
            <span class="rounded-full bg-gray-100 px-3 py-1 text-gray-700">Склад: {{ $product->stock }}</span>
            <span>Добавлено: {{ optional($product->created_at)->format('d.m.Y') }}</span>
        </div>
    </div>
</div>
