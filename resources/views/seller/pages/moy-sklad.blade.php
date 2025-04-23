@extends('seller.layouts.app')
@section('content')
<div class="max-w-lg">
    <h2 class="mb-4 text-2xl font-semibold">Настройки МойСклад</h2>
    <form action="{{ route('moyskladbigupdate') }}" method="POST">
        @csrf
        <button type="submit" class="w-full px-4 py-2 mb-3 font-semibold text-white transition duration-300 bg-blue-600 rounded-lg shadow-md hover:bg-blue-700">
            Синхронизация всех товаров из МойСклад
        </button>
    </form>
    <form action="{{ route('moyskladbigupdate') }}" method="POST">
        @csrf
        <button class="w-full px-4 py-2 mb-3 font-semibold text-white transition duration-300 bg-green-600 rounded-lg shadow-md hover:bg-green-700">
            Обновить данные всех товаров из МойСклад
        </button>
    </form>
    <form action="{{ route('updateStockQuantities') }}" method="POST">

        @csrf
        <button class="w-full px-4 py-2 font-semibold text-white transition duration-300 bg-purple-600 rounded-lg shadow-md hover:bg-purple-700">
            Обновить количество товаров из МойСклад
        </button>
    </form>
</div>


@endsection
