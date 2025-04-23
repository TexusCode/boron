@extends('seller.layouts.app')

@section('content')
<div class="max-w-2xl p-4 mx-auto">
    <h1 class="mb-4 text-2xl font-bold">Настройки продавца</h1>

    @if (session('success'))
    <div class="p-2 mb-4 text-green-800 bg-green-100 rounded">
        {{ session('success') }}
    </div>
    @endif

    <form action="{{ route('seller.updateSettings') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf

        <div>
            <label for="store_name" class="block font-medium">Название магазина</label>
            <input type="text" name="store_name" id="store_name" value="{{ $seller->store_name ?? '' }}" required class="block w-full p-2 mt-1 border rounded">
        </div>

        <div>
            <label for="store_phone" class="block font-medium">Телефон магазина</label>
            <input type="text" name="store_phone" id="store_phone" value="{{ $seller->store_phone ?? '' }}" required class="block w-full p-2 mt-1 border rounded">
        </div>

        <div>
            <label for="store_description" class="block font-medium">Описание магазина</label>
            <textarea name="store_description" id="store_description" class="block w-full p-2 mt-1 border rounded">{{ $seller->description ?? '' }}</textarea>
        </div>

        <div>
            <label for="store_logo" class="block font-medium">Логотип магазина</label>
            <input type="file" name="store_logo" id="store_logo" class="block w-full p-2 mt-1 border rounded">
        </div>

        <div>
            <label class="flex items-center">
                <input type="checkbox" name="enable_moysklad" value="1" {{ $seller->moy_sklad ? 'checked' : '' }} class="mr-2">
                Включить Мойсклад
            </label>
        </div>

        <div>
            <label for="moysklad_login" class="block font-medium">Логин Мойсклад</label>
            <input type="text" name="moysklad_login" id="moysklad_login" value="{{ $seller->moysklad_login ?? '' }}" class="block w-full p-2 mt-1 border rounded">
        </div>

        <div>
            <label for="moysklad_password" class="block font-medium">Пароль Мойсклад</label>
            <input type="password" name="moysklad_password" id="moysklad_password" value="{{ $seller->moysklad_password ?? '' }}" class="block w-full p-2 mt-1 border rounded">
        </div>

        <button type="submit" class="w-full p-2 mt-4 text-white bg-blue-600 rounded">Сохранить настройки</button>
    </form>
</div>
@endsection
