@extends('admin.layouts.app')
@section('content')
<div class="">
    <h2 class="mb-6 text-2xl font-semibold text-gray-800">Добавить Доставщика</h2>

    <form action="{{ route('add-deliver-post') }}" method="POST" enctype="multipart/form-data">

        @csrf
        <div class="grid grid-cols-1 gap-6">

            <!-- Name -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Имя Доставщика</label>
                <input type="text" id="name" name="name" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
            </div>

            <!-- Phone -->
            <div>
                <label for="phone" class="block text-sm font-medium text-gray-700">Телефон</label>
                <input type="text" id="phone" name="phone" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
            </div>

            <!-- Passport Front -->
            <div>
                <label for="passport_front" class="block text-sm font-medium text-gray-700">Фото Паспорт (Лицевая Сторона)</label>
                <input type="file" id="passport_front" name="passport_front" accept="image/*" class="block w-full mt-1 text-gray-500">
            </div>

            <!-- Passport Back -->
            <div>
                <label for="passport_back" class="block text-sm font-medium text-gray-700">Фото Паспорт (Обратная Сторона)</label>
                <input type="file" id="passport_back" name="passport_back" accept="image/*" class="block w-full mt-1 text-gray-500">
            </div>

            <!-- Submit Button -->
            <div class="flex justify-start">
                <button type="submit" class="px-4 py-2 font-semibold text-white bg-blue-600 rounded-lg shadow-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    Добавить Доставщика
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
