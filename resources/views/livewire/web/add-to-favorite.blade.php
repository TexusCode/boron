<button type="button" wire:click="addTofavorite" class="rounded-lg absolute top-1 right-1">
    <svg class="h-5 w-5 {{ $isfavorite ? 'fill-red-700' : 'fill-none' }} text-red-700 fill-none hover:fill-red-700 duration-200" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6C6.5 1 1 8 5.8 13l6.2 7 6.2-7C23 8 17.5 1 12 6Z" />
    </svg>
</button>
