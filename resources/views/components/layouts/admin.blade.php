<!-- Destination: resources/views/components/layouts/admin.blade.php -->
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Admin · CitiMaids' }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@600;700;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <style>[x-cloak]{display:none!important}</style>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="bg-slate-50 font-['Inter']" style="font-family: 'Inter', sans-serif;">

    <div class="flex min-h-screen">
        {{-- Sidebar --}}
        <aside class="flex w-64 flex-shrink-0 flex-col bg-[#123C69] text-white">
            <a href="{{ route('admin.dashboard') }}" wire:navigate class="flex h-16 items-center gap-2 px-6">
                <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-white/10">
                    <x-heroicon-s-sparkles class="h-5 w-5 text-[#4FD1C5]" />
                </span>
                <span class="text-lg font-bold">Citi<span class="text-[#4FD1C5]">Maids</span></span>
            </a>

            <nav class="mt-6 flex-1 space-y-1 px-3">
                <a href="{{ route('admin.dashboard') }}" wire:navigate
                   class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition
                          {{ request()->routeIs('admin.dashboard') ? 'bg-white/10 text-white' : 'text-blue-100 hover:bg-white/10 hover:text-white' }}">
                    <x-heroicon-o-squares-2x2 class="h-4 w-4" /> Dashboard
                </a>
                <a href="{{ route('admin.bookings') }}" wire:navigate
                   class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition
                          {{ request()->routeIs('admin.bookings') ? 'bg-white/10 text-white' : 'text-blue-100 hover:bg-white/10 hover:text-white' }}">
                    <x-heroicon-o-calendar-days class="h-4 w-4" /> Bookings
                </a>
            </nav>

            <div class="border-t border-white/10 p-3">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                            class="flex w-full items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-blue-100 transition hover:bg-white/10 hover:text-white">
                        <x-heroicon-o-arrow-left-on-rectangle class="h-4 w-4" /> Log out
                    </button>
                </form>
            </div>
        </aside>

        {{-- Content --}}
        <main class="flex-1 p-8">
            {{ $slot }}
        </main>
    </div>

    @livewireScripts
</body>
</html>