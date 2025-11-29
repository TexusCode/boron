@extends('seller.layouts.app')
@section('content')
<div class="">
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow-sm">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2 font-semibold text-left text-gray-600 whitespace-nowrap">Номер заказа</th>
                    <th class="px-4 py-2 font-semibold text-left text-gray-600 whitespace-nowrap">Товар</th>
                    <th class="px-4 py-2 font-semibold text-left text-gray-600 whitespace-nowrap">Дата и время</th>
                    <th class="px-4 py-2 font-semibold text-left text-gray-600 whitespace-nowrap">Статус</th>
                    <th class="px-4 py-2 font-semibold text-left text-gray-600 whitespace-nowrap">Сумма</th>
                    <th class="px-4 py-2 font-semibold text-left text-gray-600 whitespace-nowrap">Скидка</th>
                    <th class="flex justify-end px-4 py-2 font-semibold text-left text-gray-600 whitespace-nowrap">Действия</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($orders as $suborder)
                @php
                    $product = $suborder->product;
                    $mainOrder = $suborder->order;
                    $lineTotal = ($suborder->price * $suborder->count) - ($suborder->discount ?? 0);
                    $miniature = $product->miniature ?? null;
                    $thumbPath = $miniature ? 'thumbs/' . ltrim($miniature, '/') : null;
                    $imagePath = $miniature;
                    if ($thumbPath && Storage::disk('public')->exists($thumbPath)) {
                        $imagePath = $thumbPath;
                    }
                    $imageUrl = $imagePath ? asset('storage/' . $imagePath) : 'https://via.placeholder.com/120x120?text=No+Image';
                @endphp
                <tr class="border-b border-gray-200">
                    <td class="px-4 py-3 whitespace-nowrap">
                        <div class="text-sm font-semibold text-gray-900">#{{ $mainOrder->id ?? '—' }}</div>
                        <div class="text-xs text-gray-500">Субзаказ #{{ $suborder->id }}</div>
                    </td>
                    <td class="flex items-center gap-3 px-4 py-3 whitespace-nowrap">
                        <div class="w-12 h-12 overflow-hidden border rounded-md">
                            <img src="{{ $imageUrl }}" alt="{{ $product->name }}" class="object-cover w-12 h-12">
                        </div>
                        <div class="text-sm">
                            <div class="font-semibold text-gray-900 line-clamp-1">{{ $product->name ?? 'Товар удалён' }}</div>
                            <div class="text-xs text-gray-500">{{ $suborder->count }} шт</div>
                        </div>
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-600">
                        {{ optional($suborder->created_at)->format('d.m.Y H:i') ?? '—' }}
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap">
                        <span class="px-2.5 py-0.5 rounded text-sm font-medium
                            @class([
                                'bg-yellow-100 text-yellow-800' => $suborder->status === 'Ожидание',
                                'bg-green-100 text-green-800' => $suborder->status === 'Подтверждено',
                                'bg-blue-100 text-blue-800' => $suborder->status === 'Доставлен',
                                'bg-red-100 text-red-800' => $suborder->status === 'Отменено',
                                'bg-gray-100 text-gray-800' => ! $suborder->status,
                            ])">
                            {{ $suborder->status ?? '—' }}
                        </span>
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap text-sm font-semibold text-gray-900">
                        {{ number_format($lineTotal, 2, '.', ' ') }} c
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-600">
                        {{ number_format($suborder->discount ?? 0, 2, '.', ' ') }} c
                    </td>
                    <td class="flex items-center justify-end gap-3 px-4 py-3 whitespace-nowrap">
                        <a href="{{ route('order-details-seller', $suborder->order_id) }}" class="text-sm font-semibold text-blue-600 hover:underline">Подробнее</a>
                        @livewire('seller.order-confirm',['id'=>$suborder->id], key('suborder-'.$suborder->id))
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-4 py-6 text-center text-sm text-gray-500">
                        Заказы не найдены.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-4">
    {{ $orders->links('pagination::simple-tailwind') }}
</div>
@endsection
