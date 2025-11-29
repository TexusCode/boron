@extends('admin.layouts.app')

@section('content')
<div class="w-full h-full bg-gray-50">
    <h2 class="mb-4 text-2xl font-bold text-gray-800">Добавить Купон</h2>


    <!-- Форма добавления категории -->
    <form action="{{ route('add-coupones') }}" method="POST" enctype="multipart/form-data" class="grid gap-4 p-6 mx-auto bg-white rounded-lg">
        @csrf
        <label class="block">
            <span class="font-semibold text-gray-700">Код купона</span>
            <input type="text" name="code" autofocus required class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="">
        </label>
        <label class="block">
            <span class="font-semibold text-gray-700">Процент купона</span>
            <input type="text" name="percent" autofocus required class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="">
        </label>
        <label class="block">
            <span class="font-semibold text-gray-700">Где применять</span>
            <select name="scope" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                <option value="all">На все товары</option>
                <option value="category">Определённая категория</option>
            </select>
        </label>
        <label class="block">
            <span class="font-semibold text-gray-700">Категория (для выбора выше)</span>
            <select name="category_id" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                <option value="">— Выберите категорию —</option>
                @foreach ($categories as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </label>
        <label class="inline-flex items-center gap-2">
            <input type="checkbox" name="auto_apply" value="1" class="w-4 h-4 text-primary-600 border-gray-300 rounded focus:ring-primary-500" checked>
            <span class="text-sm font-medium text-gray-700">Автоматически применять и показывать скидку</span>
        </label>

        <button type="submit" class="w-full px-4 py-2 font-semibold text-white rounded-md shadow-sm bg-primary-600 hover:bg-primary-700 focus:ring-4 focus:ring-indigo-200 focus:outline-none focus:ring-opacity-50">
            Добавить купон
        </button>
    </form>

    <!-- Список категорий -->
    <div class="mt-8">
        <h2 class="mb-4 text-2xl font-bold text-gray-800">Купоны</h2>
        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
            @foreach ($coupones as $coupone)
            <div class="flex gap-4 p-2 bg-white border border-gray-200 rounded-lg shadow-md">
                <div>
                    <h3 class="text-lg font-semibold text-gray-700">Код купона: {{ $coupone->code }}</h3>
                    <p class="text-gray-500">Процент скидки: {{ $coupone->percent }}%</p>
                    <p class="text-gray-500">Применение:
                        @if($coupone->scope === 'all')
                        <span class="font-semibold text-green-600">Все товары</span>
                        @else
                        <span class="font-semibold text-blue-600">{{ $coupone->category->name ?? 'Категория удалена' }}</span>
                        @endif
                    </p>
                    <p class="text-gray-500">Авто-применение:
                        @if($coupone->auto_apply)
                        <span class="font-semibold text-green-600">Включено</span>
                        @else
                        <span class="font-semibold text-yellow-600">Только по коду</span>
                        @endif
                    </p>
                    <div class="flex gap-4">
                        <form action="{{ route('delete-coupones', $coupone->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
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
