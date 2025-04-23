<div>
    @if($suborder->status == 'Ожидание')
    <div class="flex justify-end gap-2">
        <button wire:click="confirm({{ $suborder->id }})" wire:loading.class="hidden" type="button" class="text-blue-600 hover:underline">Подтвердить</button>
        <button wire:click="cancel({{ $suborder->id }})" wire:loading.class="hidden" type="button" class="text-red-600 hover:underline">Отменить</button>
    </div>
    @else
    <div class="flex justify-end gap-2">
        <p class="font-bold text-blue-600 uppercase hover:underline">{{ $suborder->status }}</p>

    </div>
    @endif

</div>
