<div id="controls-carousel" class="relative w-full px-2 mt-2" data-carousel="static">
    <div class="overflow-hidden swiper swiper_main rounded-xl">

        <div class="swiper-wrapper">
            @foreach ($sliders as $slider)
            <div class="w-full h-full bg-black swiper-slide"><img src="{{ asset('storage/'.$slider->image) }}" class="object-cover object-center w-full h-36 lg:h-80"></div>
            @endforeach
        </div>
        <div class="hidden text-white swiper-button-prev hover:text-white/80 lg:block"></div>
        <div class="hidden text-white swiper-button-next hover:text-white/80 lg:block"></div>
    </div>
</div>


<section class="grid grid-cols-4 gap-2 px-2 mt-4 md:grid-cols-4 lg:grid-cols-6 xl:grid-cols-12 lg:gap-8">
    @foreach ($categories as $category)
    <a href="{{ route('search', ['category' => $category->id]) }}">
        <div class="overflow-hidden bg-red-500 rounded-lg aspect-h-1 aspect-w-1 lg:rounded-xl">
            <img class="object-cover object-center w-full h-full duration-200 hover:scale-110" src="{{ asset('storage/'.$category->photo) }}" alt="">
        </div>
        <p class="mt-1 overflow-hidden text-xs leading-none text-center text-ellipsis lg:leading-none line-clamp-2">{{ $category->name }}</p>
    </a>
    @endforeach
</section>
