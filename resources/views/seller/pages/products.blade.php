@extends('seller.layouts.app')
@section('content')
<form action="{{ route('update-products-selle') }}" method="GET">
    <!-- CSRF protection for POST requests -->


    @livewire('admin.action')



    <div class="grid grid-cols-2 gap-2 my-4 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 2xl:grid-cols-6">
        @foreach ($products as $product)
        @include('seller.partials.product-card')
        @endforeach
    </div>
    {{ $products->links('pagination::simple-tailwind') }}
</form>



@endsection
