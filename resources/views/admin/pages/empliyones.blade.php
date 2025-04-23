@extends('admin.layouts.app')

@section('content')
<div class="">
    <h2 class="mb-6 text-2xl font-semibold text-gray-800">Список Сотрудников</h2>

    @if(session('success'))
    <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded">
        {{ session('success') }}
    </div>
    @endif

    <div class="mb-4">
        <a href="{{ route('add-empliyone') }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-700">
            Добавить Сотрудника
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-300">
            <thead>
                <tr class="w-full text-sm leading-normal text-gray-600 uppercase bg-gray-200">
                    <th class="px-6 py-3 text-left">Имя</th>
                    <th class="px-6 py-3 text-left">Телефон</th>
                    <th class="px-6 py-3 text-left">Роль</th>
                    <th class="px-6 py-3 text-center">Действия</th>
                </tr>
            </thead>
            <tbody class="text-sm font-light text-gray-600">
                @foreach($employees as $employee)
                <tr class="border-b border-gray-200 hover:bg-gray-100">
                    <td class="px-6 py-3 whitespace-nowrap">{{ $employee->name ?? 'Имя не задано'}}</td>
                    <td class="px-6 py-3">{{ $employee->phone }}</td>
                    <td class="px-6 py-3">{{ $employee->role }}</td>
                    <td class="px-6 py-3 text-center">
                        <a href="{{ route('add-empliyone',$employee->phone ) }}" class="text-blue-600 hover:underline">Редактировать</a>
                        <form action="{{ route('delempliyonepost', $employee->id) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="text-red-600 hover:underline">Удалить</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>
@endsection
