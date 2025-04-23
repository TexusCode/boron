@extends('admin.layouts.app')

@section('content')
<div class="w-full h-full bg-gray-50">
    <h2 class="mb-4 text-2xl font-bold text-gray-800">Добавить Город</h2>


    <!-- Форма добавления категории -->
    <form action="{{ route('city-add') }}" method="POST" enctype="multipart/form-data" class="grid gap-4 p-6 mx-auto bg-white rounded-lg">
        @csrf
        <label class="block">
            <span class="font-semibold text-gray-700">Имя города</span>
            <input type="text" name="city" autofocus required class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="">
        </label>

        <button type="submit" class="w-full px-4 py-2 font-semibold text-white rounded-md shadow-sm bg-primary-600 hover:bg-primary-700 focus:ring-4 focus:ring-indigo-200 focus:outline-none focus:ring-opacity-50">
            Добавить город
        </button>
    </form>

    <div class="mt-8">
        <h2 class="mb-4 text-2xl font-bold text-gray-800">Городы</h2>
        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
            @foreach ($cities as $city)
            <div class="flex gap-4 p-2 bg-white border border-gray-200 rounded-lg shadow-md">
                <div>
                    <h3 class="text-lg font-semibold text-gray-700">Имя города: {{ $city->name }}</h3>

                    <div class="flex gap-4">
                        <form action="{{ route('city-del', $city->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="px-3 py-1 text-white bg-red-600 rounded-lg hover:bg-red-700">
                                Удалить
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
