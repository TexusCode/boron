<li>
    @if($togle)
        <a href="{{ route('moysklad-settings') }}"
           @class([
               'flex items-center gap-3 rounded-2xl px-4 py-3 transition-all duration-200',
               'bg-white text-slate-900 shadow-lg' => request()->routeIs('moysklad-settings'),
               'text-slate-200 hover:bg-white/10 hover:text-white' => !request()->routeIs('moysklad-settings'),
           ])>
            <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                <path d="M10.83 5a3.001 3.001 0 0 0-5.66 0H4a1 1 0 1 0 0 2h1.17a3.001 3.001 0 0 0 5.66 0H20a1 1 0 1 0 0-2h-9.17ZM4 11h9.17a3.001 3.001 0 0 1 5.66 0H20a1 1 0 1 1 0 2h-1.17a3.001 3.001 0 0 1-5.66 0H4a1 1 0 1 1 0-2Zm1.17 6H4a1 1 0 1 0 0 2h1.17a3.001 3.001 0 0 0 5.66 0H20a1 1 0 1 0 0-2h-9.17a3.001 3.001 0 0 0-5.66 0Z" />
            </svg>
            <span class="flex-1 whitespace-nowrap">Настройки МойСклад</span>
        </a>
    @else
        <span class="hidden"></span>
    @endif
</li>
