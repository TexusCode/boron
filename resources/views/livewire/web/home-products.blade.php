<section class="antialiased dark:bg-gray-900">
    <div class="max-w-screen-xl px-2 mx-auto mt-2 2xl:px-0">
        <div class="items-end justify-between pb-2 space-y-4 sm:flex sm:space-y-0">
            <div>
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white sm:text-2xl">Рекомендуемые товары</h2>
            </div>
        </div>
        <div id="product-list" class="grid grid-cols-2 gap-1 mb-4 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-6">
            @foreach ($products as $product)

            <div wire:ignore wire:key="{{ $product->id }}">
                @include('web.partials.product-card')
            </div>
            @endforeach
        </div>
        <div x-intersect="$wire.loading()" class="flex justify-center w-full">
            Загрузка...
        </div>
    </div>
</section>
