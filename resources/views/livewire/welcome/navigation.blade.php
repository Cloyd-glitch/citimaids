{{-- Destination: resources/views/livewire/welcome/navigation.blade.php --}}

<nav
    x-data="{ open: false, scrolled: window.scrollY > 12 }"
    @scroll.window="scrolled = window.scrollY > 12"
    :class="scrolled ? 'bg-white/95 backdrop-blur shadow-sm border-b border-slate-100' : 'bg-transparent'"
    class="fixed inset-x-0 top-0 z-50 transition-colors duration-300"
>
    <div class="mx-auto flex h-16 max-w-7xl items-center justify-between px-6 lg:px-8">

        {{-- Logo --}}
        <a href="{{ url('/') }}" wire:navigate class="flex items-center gap-2">
            <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-[#123C69]">
                <x-heroicon-s-sparkles class="h-5 w-5 text-[#4FD1C5]" />
            </span>
            <span class="text-lg font-bold tracking-tight" :class="scrolled ? 'text-[#123C69]' : 'text-white'">
                Citi<span class="text-[#4FD1C5]">Maids</span>
            </span>
        </a>

        {{-- Desktop links --}}
        <div class="hidden items-center gap-8 lg:flex">
            @foreach ($links as $link)
                <a
                    href="{{ $link['href'] }}"
                    wire:navigate
                    class="text-sm font-medium transition-colors"
                    :class="scrolled ? 'text-slate-600 hover:text-[#123C69]' : 'text-white/90 hover:text-white'"
                >
                    {{ $link['label'] }}
                </a>
            @endforeach
        </div>

        {{-- Desktop actions --}}
        <div class="hidden items-center gap-3 lg:flex">
            @auth
                <a href="{{ url('/dashboard') }}" wire:navigate
                   class="text-sm font-medium"
                   :class="scrolled ? 'text-slate-600 hover:text-[#123C69]' : 'text-white/90 hover:text-white'">
                    Dashboard
                </a>
            @else
                <a href="{{ url('/login') }}" wire:navigate
                   class="text-sm font-medium transition-colors"
                   :class="scrolled ? 'text-slate-600 hover:text-[#123C69]' : 'text-white/90 hover:text-white'">
                    Log in
                </a>
            @endauth
            <a href="{{ url('/quote') }}" wire:navigate
               class="rounded-full bg-[#F6AD37] px-5 py-2.5 text-sm font-semibold text-[#123C69] shadow-sm transition hover:bg-[#f5a01c]">
                Get a Free Quote
            </a>
        </div>

        {{-- Mobile toggle --}}
        <button
            @click="open = !open"
            class="grid h-10 w-10 place-items-center rounded-lg lg:hidden"
            :class="scrolled ? 'text-[#123C69]' : 'text-white'"
            aria-label="Toggle menu"
        >
            <svg x-show="!open" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
            <svg x-show="open" x-cloak class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    {{-- Mobile panel --}}
    <div
        x-show="open"
        x-cloak
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 -translate-y-2"
        x-transition:enter-end="opacity-100 translate-y-0"
        @click.outside="open = false"
        class="border-t border-slate-100 bg-white px-6 py-4 lg:hidden"
    >
        <div class="flex flex-col gap-1">
            @foreach ($links as $link)
                <a href="{{ $link['href'] }}" wire:navigate @click="open = false"
                   class="rounded-lg px-3 py-2.5 text-sm font-medium text-slate-700 hover:bg-slate-50">
                    {{ $link['label'] }}
                </a>
            @endforeach
            <div class="mt-3 flex flex-col gap-2 border-t border-slate-100 pt-3">
                @auth
                    <a href="{{ url('/dashboard') }}" wire:navigate class="rounded-lg px-3 py-2.5 text-sm font-medium text-slate-700 hover:bg-slate-50">Dashboard</a>
                @else
                    <a href="{{ url('/login') }}" wire:navigate class="rounded-lg px-3 py-2.5 text-sm font-medium text-slate-700 hover:bg-slate-50">Log in</a>
                @endauth
                <a href="{{ url('/quote') }}" wire:navigate class="rounded-full bg-[#F6AD37] px-4 py-2.5 text-center text-sm font-semibold text-[#123C69]">Get a Free Quote</a>
            </div>
        </div>
    </div>
</nav>