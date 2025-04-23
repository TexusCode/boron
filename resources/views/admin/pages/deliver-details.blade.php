@extends('admin.layouts.app')

@section('content')
<div class="container mx-auto mt-8">
    <h2 class="mb-6 text-2xl font-semibold text-gray-800">Детали Доставщика</h2>

    <div class="p-6 bg-white rounded-lg shadow">
        <div class="mb-4">
            <h3 class="text-xl font-semibold">Имя: {{ $deliver->name }}</h3>
            <p class="text-gray-700">Телефон: {{ $deliver->phone }}</p>
        </div>

        <div class="mb-4">
            <h4 class="text-lg font-semibold">Паспорт</h4>
            <div class="flex space-x-4">
                <div>
                    <h5 class="font-semibold">Лицевая Сторона</h5>
                    <img src="{{ asset('storage/'.$deliver->passport_front) }}" alt="Паспорт (Лицевая Сторона)" class="w-64 h-auto border rounded">

                </div>
                <div>
                    <h5 class="font-semibold">Обратная Сторона</h5>
                    <img src="{{ asset('storage/'.$deliver->passport_back )}}" alt="Паспорт (Обратная Сторона)" class="w-64 h-auto border rounded">


                </div>
            </div>
        </div>

        <div class="mt-4">
            <a href="{{ route('delivers') }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-700">
                Вернуться к списку
            </a>
        </div>
    </div>
</div>
@endsection
