<!-- Destination: resources/views/components/layouts/guest.blade.php -->
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'CitiMaids' }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@600;700;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <style>[x-cloak]{display:none!important}</style>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="bg-slate-50 font-['Inter']" style="font-family: 'Inter', sans-serif;">

    <div class="relative flex min-h-screen items-center justify-center overflow-hidden px-6 py-12">
        <div class="pointer-events-none absolute inset-x-0 top-0 h-72 bg-gradient-to-br from-[#123C69] to-[#0B2A4A]"></div>
        <div class="pointer-events-none absolute inset-x-0 top-0 h-72 opacity-[0.07]"
             style="background-image:radial-gradient(circle,#fff 1px,transparent 1px);background-size:22px 22px;"></div>

        <div class="relative w-full max-w-md rounded-2xl bg-white p-8 shadow-2xl sm:p-10">
            {{ $slot }}
        </div>
    </div>

    @livewireScripts
</body>
</html>