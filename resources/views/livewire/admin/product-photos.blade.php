<div class="grid grid-cols-6 gap-2">
    <div class="relative overflow-hidden aspect-h-1 aspect-w-1 rounded-xl">
        <img src="{{ asset('storage/'.$product->miniature) }}" class="object-cover object-center w-full h-full" alt="">


    </div>
    @foreach ($product->otherphotos as $photo)
    <div class="relative overflow-hidden aspect-h-1 aspect-w-1 rounded-xl">
        <div>
            <img src="{{ asset('storage/'.$photo->photo) }}" class="object-cover object-center w-full h-full" alt="">

            <button type="button" wire:click="remove({{ $photo->id }})" class="absolute p-1 bg-white rounded-full top-3 right-3 text-primary-500 hover:text-primary-700">
                <svg class="w-6 h-6 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z" />
                </svg>
            </button>
        </div>
    </div>
    @endforeach
</div>
