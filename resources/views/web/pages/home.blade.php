@extends('web.layouts.app')
@section('content')
<div class="whatsapp-button-wrapper">
  <a href="https://wa.me/+992100604040?text=Салом!" class="whatsapp-button" aria-label="Chat on WhatsApp">
    <div class="notification-badge-wrapper">
      <div class="notification-badge">
        <span class="ping"></span>
        <span class="badge-text">1</span>
      </div>
    </div>

    <svg
      viewBox="0 0 16 16"
      class="whatsapp-icon"
      fill="currentColor"
      height="24"
      width="24"
      xmlns="http://www.w3.org/2000/svg"
    >
      <path
        d="M13.601 2.326A7.85 7.85 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.9 7.9 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.9 7.9 0 0 0 13.6 2.326zM7.994 14.521a6.6 6.6 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.56 6.56 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592m3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.73.73 0 0 0-.529.247c-.182.198-.691.677-.691 1.654s.71 1.916.81 2.049c.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232"
      ></path>
    </svg>

    <span class="pulse-border"></span>

    <div class="tooltip">
      <div class="tooltip-text">Есть вопросы? Напишите нам!</div>
      <div class="tooltip-arrow"></div>
    </div>
  </a>
</div>
<div class="max-w-screen-xl mx-auto">
    @include('web.partials.home-slider')
    <section class="antialiased dark:bg-gray-900">
        <div class="max-w-screen-xl px-2 mx-auto mt-2 2xl:px-0">
            <div class="items-end justify-between pb-2 space-y-4 sm:flex sm:space-y-0">
                <div>
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white sm:text-2xl">Рекомендуемые товары</h2>
                </div>
            </div>
            <div id="posts-container">
                @include('web.loads')
            </div>

            @if($products->hasMorePages())

            <div class="flex justify-center w-full">
                Загрузка...
            </div>
            @endif


        </div>
    </section>


    {{-- @livewire('web.home-products') --}}
</div>
@endsection
@section('styles')
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css">
<script src="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js"></script>
<style>
    .whatsapp-button-wrapper {
  position: fixed;
  bottom: 8rem; /* bottom-14 */
  right: 4rem; /* right-5 */
  z-index: 99999;
}

.whatsapp-button {
  position: absolute;
  background-color: #22c55e; /* green-500 */
  color: white;
  width: 3.5rem; /* w-14 */
  height: 3.5rem; /* h-14 */
  border-radius: 9999px; /* full */
  display: flex;
  justify-content: center;
  align-items: center;
  box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1), 0 4px 6px -4px rgba(0,0,0,0.1); /* shadow-lg */
  transition: all 0.3s ease-out;
  z-index: 50;
  border: none;
  cursor: pointer;
}

.whatsapp-button:hover {
  background-color: #16a34a; /* green-600 */
  transform: scale(1.05);
}

.whatsapp-button:active {
  transform: scale(0.95);
}

.notification-badge-wrapper {
  position: absolute;
  top: -0.25rem;
  right: -0.25rem;
  z-index: 10;
}

.notification-badge {
  display: flex;
  width: 1.5rem;
  height: 1.5rem;
  align-items: center;
  justify-content: center;
  position: relative;
}

.ping {
  position: absolute;
  height: 100%;
  width: 100%;
  background-color: #f87171; /* red-400 */
  border-radius: 9999px;
  opacity: 0.75;
  animation: ping 1s cubic-bezier(0, 0, 0.2, 1) infinite;
}

@keyframes ping {
  0% {
    transform: scale(1);
    opacity: 1;
  }
  75%, 100% {
    transform: scale(2);
    opacity: 0;
  }
}

.badge-text {
  position: relative;
  display: inline-flex;
  height: 1.25rem;
  width: 1.25rem;
  align-items: center;
  justify-content: center;
  font-size: 0.75rem;
  font-weight: bold;
  color: white;
  background-color: #ef4444; /* red-500 */
  border-radius: 9999px;
}

.whatsapp-icon {
  width: 1.75rem; /* w-7 */
  height: 1.75rem; /* h-7 */
}

.pulse-border {
  position: absolute;
  inset: 0;
  border-radius: 9999px;
  border: 4px solid rgba(255, 255, 255, 0.3);
  animation: pulse 2s infinite;
}

@keyframes pulse {
  0% {
    transform: scale(1);
    opacity: 1;
  }
  100% {
    transform: scale(1.5);
    opacity: 0;
  }
}

.tooltip {
  position: absolute;
  right: 100%;
  margin-right: 0.75rem; /* mr-3 */
  opacity: 0;
  visibility: hidden;
  transition: all 0.3s;
  white-space: nowrap;
}

.whatsapp-button:hover .tooltip {
  opacity: 1;
  visibility: visible;
}

.tooltip-text {
  background-color: #1f2937; /* gray-800 */
  color: white;
  font-size: 0.875rem;
  padding: 0.25rem 0.75rem;
  border-radius: 0.25rem;
  box-shadow: 0 4px 6px rgba(0,0,0,0.1);
}

.tooltip-arrow {
  position: absolute;
  top: 50%;
  right: 0;
  transform: translateX(50%) translateY(-50%) rotate(45deg);
  width: 0.5rem;
  height: 0.5rem;
  background-color: #1f2937; /* gray-800 */
}

</style>
@endsection
@section('scripts')
<script>
    $(document).ready(function() {
        let nextPageUrl = '{{ $products->nextPageUrl() }}';

        $(window).scroll(function() {
            if ($(window).scrollTop() + $(window).height() >= $(document).height() - 100) {
                if (nextPageUrl) {
                    loadMorePosts();
                }
            }
        });

        function loadMorePosts() {
            $.ajax({
                url: nextPageUrl
                , type: 'get'
                , beforeSend: function() {
                    nextPageUrl = '';
                }
                , success: function(data) {
                    nextPageUrl = data.nextPageUrl;
                    $('#posts-container').append(data.view);
                }
                , error: function(xhr, status, error) {
                    console.error("Error loading more posts:", error);
                }
            });
        }
    });

</script>



<script>
    const swiper = new Swiper('.swiper_main', {
        loop: true
        , autoplay: {
            delay: 2000
        , }
        , navigation: {
            nextEl: ".swiper-button-next"
            , prevEl: ".swiper-button-prev"
        , }
    , })

</script>
@endsection
