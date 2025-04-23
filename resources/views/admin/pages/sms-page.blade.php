@extends('admin.layouts.app')
@section('content')
<div class="w-full max-w-md mx-auto space-y-6">

    <!-- Форма 1: Номер телефона и текстовое сообщение -->
    <div class="p-6 bg-white rounded-lg shadow-md">
        <h2 class="mb-4 text-xl font-semibold">Отправить SMS</h2>
        <form action="{{ route('onesms') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="phone" class="block font-medium text-gray-700">Номер телефона</label>
                <input type="tel" id="phone" name="phone" class="w-full p-2 mt-1 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="+992901234567" required>
            </div>
            <div class="mb-4">
                <label for="message" class="block font-medium text-gray-700">Сообщение</label>
                <textarea id="message" name="message" rows="4" class="w-full p-2 mt-1 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Введите ваше сообщение..." required></textarea>
            </div>
            <button type="submit" class="w-full py-2 text-white transition bg-blue-600 rounded-md hover:bg-blue-700">Отправить SMS</button>
        </form>
    </div>

    <!-- Форма 2: Только текстовое сообщение -->
    <div class="p-6 bg-white rounded-lg shadow-md">
        <h2 class="mb-4 text-xl font-semibold">Отправить SMS Рассылка</h2>
        <form action="{{ route('sms-many') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="simpleMessage" class="block font-medium text-gray-700">Сообщение</label>
                <textarea id="simpleMessage" name="simpleMessage" rows="4" class="w-full p-2 mt-1 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Введите ваше сообщение..." required></textarea>
            </div>
            <button type="submit" class="w-full py-2 text-white transition bg-blue-600 rounded-md hover:bg-blue-700">Отправить</button>
        </form>
    </div>

</div>

@endsection
