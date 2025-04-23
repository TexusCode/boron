@extends('admin.layouts.app')

@section('content')
<div class="">
    <h2 class="mb-6 text-2xl font-semibold text-gray-800">Список Доставщиков</h2>

    @if(session('success'))
    <div class="mb-4 text-green-600">
        {{ session('success') }}
    </div>
    @endif

    <div class="overflow-auto border-b border-gray-200 rounded-lg shadow">
        <table class="min-w-full bg-white">
            <thead class="bg-gray-200">
                <tr>
                    <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Имя</th>
                    <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Телефон</th>
                    <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Статус</th>
                    <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Онлайн?</th>
                    <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Действия</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($delivers as $deliver)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $deliver->name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $deliver->phone }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($deliver->status == 1)
                        Активно
                        @else
                        Не активно
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($deliver->isonline == 1)
                        Да
                        @else
                        Неть
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <a href="{{ route('show-deliver', $deliver->id) }}" class="text-blue-600 hover:underline">Показать</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
