@extends('admin.layouts.app')

@section('content')
<div class="">
    <h2 class="mb-6 text-2xl font-semibold text-gray-800">{{ $employee ? 'Изменить' : 'Добавить'}} Сотрудника</h2>
    <form action="{{ route('add-empliyone-post') }}" method="POST" class="p-6 bg-white rounded-lg shadow">
        @csrf

        <div class="mb-4">
            <label for="name" class="block text-gray-700">Имя</label>
            <input type="text" id="name" name="name" value="{{ $employee ? $employee->name : ''}}" required class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">


        </div>

        <div class="mb-4">
            <label for="phone" class="block text-gray-700">Телефон</label>
            <input type="text" id="phone" name="phone" value="{{ $employee ? $employee->phone : ''}}" required class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">

        </div>

        <div class="mb-4">
            <label for="role" class="block text-gray-700">Роль</label>
            <select id="role" name="role" required class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                <option value="">Выберите Роль</option>
                <option value="admin" {{ isset($employee) && $employee->role == 'admin' ? 'selected' : '' }}>Администратор</option>
                <option value="manager" {{ isset($employee) && $employee->role == 'manager' ? 'selected' : '' }}>Менеджер</option>
                <option value="staff" {{ isset($employee) && $employee->role == 'staff' ? 'selected' : '' }}>Сотрудник</option>
                <!-- Add more roles as necessary -->
            </select>
        </div>

        <div class="mt-4">
            <button type="submit" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-700">
                {{ $employee ? 'Изменить' : 'Добавить'}}
            </button>
        </div>
    </form>
</div>
@endsection
