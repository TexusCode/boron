<div id="product-list" class="grid grid-cols-2 gap-1 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-6">
    @foreach ($products as $product)
    @include('web.partials.product-card')
    @endforeach
</div>
