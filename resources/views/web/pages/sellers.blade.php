@extends('web.layouts.app')
@section('content')
<section class="bg-white">
    <div class="max-w-screen-xl px-2 mx-auto mt-4 mb-12">
        <div class="max-w-screen-xl text-gray-500 sm:text-lg dark:text-gray-400">

            <h2 class="mb-4 text-4xl font-bold tracking-tight text-gray-900">Все продавцы</h2>
            <div class="grid grid-cols-1 gap-1 mb-4 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-4">
                @foreach ($sellers as $seller)
                @include('web.partials.seller-card')
                @endforeach
            </div>
        </div>
    </div>
</section>

@endsection
