<div class="flex items-center gap-2">
    @if($suborder->status == 'Ожидание')
        <button
            wire:click="confirm({{ $suborder->id }})"
            type="button"
            class="inline-flex items-center rounded-full bg-emerald-50 px-3 py-1 text-xs font-semibold text-emerald-600 ring-1 ring-emerald-200 transition hover:bg-emerald-500 hover:text-white">
            Подтвердить
        </button>
        <button
            wire:click="cancel({{ $suborder->id }})"
            type="button"
            class="inline-flex items-center rounded-full bg-rose-50 px-3 py-1 text-xs font-semibold text-rose-600 ring-1 ring-rose-200 transition hover:bg-rose-500 hover:text-white">
            Отменить
        </button>
    @else
        <span class="inline-flex items-center rounded-full bg-gray-100 px-3 py-1 text-xs font-semibold text-gray-500">
            {{ $suborder->status }}
        </span>
    @endif
</div>
