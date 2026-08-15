<!-- Destination: resources/views/welcome.blade.php -->
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CitiMaids - Professional Cleaning Services in Abu Dhabi</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@600;700;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <style>[x-cloak]{display:none!important}</style>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="bg-slate-50 font-['Inter']" style="font-family: 'Inter', sans-serif;">
<div class="min-h-screen">

    <livewire:welcome.navigation />

    {{-- ============ HERO ============ --}}
    <section class="relative overflow-hidden bg-gradient-to-br from-[#123C69] to-[#0B2A4A] pb-24 pt-32 text-white lg:pb-32 lg:pt-40">
        {{-- subtle dot texture --}}
        <div class="pointer-events-none absolute inset-0 opacity-[0.07]"
             style="background-image:radial-gradient(circle,#fff 1px,transparent 1px);background-size:22px 22px;"></div>

        <div class="relative mx-auto grid max-w-7xl gap-16 px-6 lg:grid-cols-2 lg:items-center lg:px-8">

            {{-- Left: copy --}}
            <div>
                <span class="inline-flex items-center gap-2 rounded-full bg-white/10 px-4 py-1.5 text-xs font-semibold text-[#4FD1C5] ring-1 ring-white/20">
                    <x-heroicon-s-map-pin class="h-3.5 w-3.5" /> Abu Dhabi's Trusted Cleaning Service
                </span>

                <h1 class="mt-6 font-['Plus_Jakarta_Sans'] text-4xl font-extrabold leading-tight lg:text-6xl" style="font-family:'Plus Jakarta Sans',sans-serif;">
                    Spotless spaces,<br>
                    <span class="text-[#4FD1C5]">zero stress.</span>
                </h1>

                <p class="mt-6 max-w-xl text-lg leading-relaxed text-blue-100">
                    Book trusted home, office, villa & deep cleaning services with trained professionals. Affordable hourly rates starting from AED 35/hour.
                </p>

                <div class="mt-8 flex flex-wrap gap-4">
                    <a href="{{ url('/quote') }}" wire:navigate
                       class="rounded-lg bg-[#F6AD37] px-8 py-4 font-semibold text-[#123C69] shadow-lg transition hover:bg-[#f5a01c]">
                        Get a Free Quote
                    </a>
                    <a href="{{ url('/services') }}" wire:navigate
                       class="rounded-lg border border-white/30 px-8 py-4 font-semibold text-white transition hover:bg-white/10">
                        View Services
                    </a>
                </div>

                <div class="mt-10 flex flex-wrap items-center gap-6 text-sm text-blue-100">
                    <span class="flex items-center gap-1.5"><x-heroicon-s-check-circle class="h-4 w-4 text-[#4FD1C5]" /> 50+ Trusted Cleaners</span>
                    <span class="flex items-center gap-1.5"><x-heroicon-s-star class="h-4 w-4 text-[#4FD1C5]" /> 4.9 Rating</span>
                    <span class="flex items-center gap-1.5"><x-heroicon-s-check-circle class="h-4 w-4 text-[#4FD1C5]" /> 1,000+ Happy Customers</span>
                </div>
            </div>

            {{-- Right: instant estimate widget (signature interactive element) --}}
            <div
                x-data="{
                    type: 'apartment',
                    rooms: 2,
                    deep: false,
                    rates: { apartment: 35, villa: 45, office: 40 },
                    get hours() { return Math.max(2, this.rooms * 0.75 + (this.deep ? 1.5 : 0)) },
                    get estimate() { return Math.round(this.hours * this.rates[this.type]) }
                }"
                class="rounded-2xl bg-white p-7 text-slate-800 shadow-2xl"
            >
                <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">Instant Estimate</p>
                <p class="mt-1 text-sm text-slate-500">Adjust the details — the price updates as you go.</p>

                {{-- Property type --}}
                <div class="mt-5">
                    <label class="text-xs font-semibold text-slate-500">Property type</label>
                    <div class="mt-2 grid grid-cols-3 gap-2">
                        <button type="button" @click="type = 'apartment'"
                                class="rounded-lg py-2 text-xs font-semibold transition"
                                :class="type === 'apartment' ? 'bg-[#123C69] text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200'">
                            Apartment
                        </button>
                        <button type="button" @click="type = 'villa'"
                                class="rounded-lg py-2 text-xs font-semibold transition"
                                :class="type === 'villa' ? 'bg-[#123C69] text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200'">
                            Villa
                        </button>
                        <button type="button" @click="type = 'office'"
                                class="rounded-lg py-2 text-xs font-semibold transition"
                                :class="type === 'office' ? 'bg-[#123C69] text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200'">
                            Office
                        </button>
                    </div>
                </div>

                {{-- Rooms stepper --}}
                <div class="mt-5 flex items-center justify-between">
                    <label class="text-xs font-semibold text-slate-500">Rooms</label>
                    <div class="flex items-center gap-3">
                        <button type="button" @click="rooms = Math.max(1, rooms - 1)"
                                class="grid h-8 w-8 place-items-center rounded-full bg-slate-100 text-slate-600 hover:bg-slate-200">−</button>
                        <span class="w-4 text-center text-sm font-semibold" x-text="rooms"></span>
                        <button type="button" @click="rooms = Math.min(10, rooms + 1)"
                                class="grid h-8 w-8 place-items-center rounded-full bg-slate-100 text-slate-600 hover:bg-slate-200">+</button>
                    </div>
                </div>

                {{-- Deep clean toggle --}}
                <div class="mt-5 flex items-center justify-between">
                    <label class="text-xs font-semibold text-slate-500">Deep clean</label>
                    <button type="button" @click="deep = !deep"
                            class="relative inline-flex h-6 w-11 items-center rounded-full transition"
                            :class="deep ? 'bg-[#4FD1C5]' : 'bg-slate-200'">
                        <span class="inline-block h-4 w-4 transform rounded-full bg-white transition"
                              :class="deep ? 'translate-x-6' : 'translate-x-1'"></span>
                    </button>
                </div>

                {{-- Result --}}
                <div class="mt-6 rounded-xl bg-slate-50 p-5">
                    <p class="text-xs font-semibold text-slate-400">Estimated total</p>
                    <p class="mt-1 text-3xl font-extrabold text-[#123C69]">
                        AED <span x-text="estimate"></span>
                    </p>
                    <p class="text-xs text-slate-400">≈ <span x-text="hours.toFixed(1)"></span> hrs at AED <span x-text="rates[type]"></span>/hr</p>
                </div>

                <a :href="'/quote?type=' + type + '&rooms=' + rooms + (deep ? '&deep=1' : '')"
                   wire:navigate
                   class="mt-4 block rounded-lg bg-[#123C69] py-3 text-center text-sm font-semibold text-white transition hover:bg-[#0d2c4e]">
                    Book This Estimate
                </a>
            </div>
        </div>
    </section>

    {{-- ============ SERVICES ============ --}}
    <section id="services" class="mx-auto max-w-7xl px-6 py-24 lg:px-8">
        <div class="mx-auto max-w-2xl text-center">
            <p class="text-sm font-semibold uppercase tracking-wide text-[#123C69]">Our Cleaning Services</p>
            <h2 class="mt-2 font-['Plus_Jakarta_Sans'] text-3xl font-extrabold text-slate-900 lg:text-4xl" style="font-family:'Plus Jakarta Sans',sans-serif;">
                Professional cleaning, tailored to your space
            </h2>
        </div>

        <div class="mt-14 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ([
                ['icon' => 'heroicon-o-home', 'title' => 'Residential Cleaning', 'desc' => 'Regular upkeep for apartments and family homes.'],
                ['icon' => 'heroicon-o-building-office-2', 'title' => 'Office Cleaning', 'desc' => 'Scheduled cleaning that keeps workplaces presentable.'],
                ['icon' => 'heroicon-o-sparkles', 'title' => 'Deep Cleaning', 'desc' => 'A thorough top-to-bottom reset, room by room.'],
                ['icon' => 'heroicon-o-home-modern', 'title' => 'Villa Cleaning', 'desc' => 'Full-property teams for larger homes and villas.'],
                ['icon' => 'heroicon-o-truck', 'title' => 'Move-in / Move-out', 'desc' => 'A spotless handover for tenants, landlords, and buyers.'],
                ['icon' => 'heroicon-o-arrow-path', 'title' => 'Recurring Plans', 'desc' => 'Weekly or bi-weekly visits with the same trusted cleaner.'],
            ] as $service)
                <div class="group rounded-2xl border border-slate-100 bg-white p-6 shadow-sm transition hover:-translate-y-1 hover:shadow-lg">
                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-[#123C69]/10 text-[#123C69] transition group-hover:bg-[#123C69] group-hover:text-white">
                        <x-dynamic-component :component="$service['icon']" class="h-6 w-6" />
                    </div>
                    <h3 class="mt-4 font-semibold text-slate-900">{{ $service['title'] }}</h3>
                    <p class="mt-1.5 text-sm leading-relaxed text-slate-500">{{ $service['desc'] }}</p>
                </div>
            @endforeach
        </div>
    </section>

    {{-- ============ HOW IT WORKS ============ --}}
    <section id="how-it-works" class="bg-white py-24">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            <div class="mx-auto max-w-2xl text-center">
                <p class="text-sm font-semibold uppercase tracking-wide text-[#123C69]">How It Works</p>
                <h2 class="mt-2 font-['Plus_Jakarta_Sans'] text-3xl font-extrabold text-slate-900" style="font-family:'Plus Jakarta Sans',sans-serif;">
                    Booked in three steps
                </h2>
            </div>

            <div class="mt-14 grid gap-10 lg:grid-cols-3">
                @foreach ([
                    ['n' => '01', 'title' => 'Get your estimate', 'desc' => 'Tell us your property type and size — get an instant price, no sign-up needed.'],
                    ['n' => '02', 'title' => 'Pick a time', 'desc' => 'Choose a slot that works for you. One-time or recurring, your call.'],
                    ['n' => '03', 'title' => 'We handle the rest', 'desc' => 'A vetted, trained cleaner shows up on time and gets to work.'],
                ] as $step)
                    <div>
                        <span class="font-['Plus_Jakarta_Sans'] text-4xl font-extrabold text-[#4FD1C5]/60" style="font-family:'Plus Jakarta Sans',sans-serif;">{{ $step['n'] }}</span>
                        <h3 class="mt-3 text-lg font-semibold text-slate-900">{{ $step['title'] }}</h3>
                        <p class="mt-2 text-sm leading-relaxed text-slate-500">{{ $step['desc'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ============ TESTIMONIALS ============ --}}
    <section class="mx-auto max-w-3xl px-6 py-24 lg:px-8"
        x-data="{
            active: 0,
            slides: [
                { name: 'Sara A.', role: 'Villa, Al Reem Island', quote: 'Booked online in under two minutes and the estimate matched the final price exactly.' },
                { name: 'Omar K.', role: 'Office, Corniche', quote: 'We switched our office to a recurring plan with them — same cleaner every week, always reliable.' },
                { name: 'Fatima H.', role: 'Apartment, Khalifa City', quote: 'The deep clean before we moved in was genuinely spotless. Worth every dirham.' },
            ],
            timer: null,
            init() { this.timer = setInterval(() => this.active = (this.active + 1) % this.slides.length, 6000) }
        }"
    >
        <div class="text-center">
            <p class="text-sm font-semibold uppercase tracking-wide text-[#123C69]">What Customers Say</p>
        </div>

        <div class="relative mt-10 min-h-[180px]">
            <template x-for="(slide, i) in slides" :key="i">
                <div x-show="active === i" x-transition.opacity.duration.500ms class="text-center">
                    <p class="text-xl font-medium leading-relaxed text-slate-700" x-text="'\u201C' + slide.quote + '\u201D'"></p>
                    <p class="mt-5 text-sm font-semibold text-slate-900" x-text="slide.name"></p>
                    <p class="text-xs text-slate-400" x-text="slide.role"></p>
                </div>
            </template>
        </div>

        <div class="mt-6 flex justify-center gap-2">
            <template x-for="(slide, i) in slides" :key="i">
                <button @click="active = i" class="h-2 rounded-full transition-all"
                        :class="active === i ? 'w-6 bg-[#123C69]' : 'w-2 bg-slate-200'"></button>
            </template>
        </div>
    </section>

    {{-- ============ FAQ ============ --}}
    <section id="faq" class="bg-white py-24">
        <div class="mx-auto max-w-3xl px-6 lg:px-8">
            <div class="text-center">
                <p class="text-sm font-semibold uppercase tracking-wide text-[#123C69]">FAQ</p>
                <h2 class="mt-2 font-['Plus_Jakarta_Sans'] text-3xl font-extrabold text-slate-900" style="font-family:'Plus Jakarta Sans',sans-serif;">
                    Good to know
                </h2>
            </div>

            <div class="mt-10 divide-y divide-slate-100" x-data="{ openIndex: 0 }">
                @foreach ([
                    ['q' => 'Do you bring your own supplies?', 'a' => 'Yes — every cleaner arrives with their own equipment and eco-friendly supplies at no extra cost.'],
                    ['q' => 'Can I reschedule or cancel a booking?', 'a' => 'Yes, free of charge up to 24 hours before your scheduled visit.'],
                    ['q' => 'Are your cleaners vetted?', 'a' => 'Every cleaner is background-checked, trained, and insured before their first booking.'],
                    ['q' => 'How is the price calculated?', 'a' => 'Pricing is based on property type, size, and whether you choose a standard or deep clean — the estimate above gives you a live figure.'],
                ] as $i => $faq)
                    <div class="py-4">
                        <button type="button" @click="openIndex = openIndex === {{ $i }} ? null : {{ $i }}"
                                class="flex w-full items-center justify-between text-left">
                            <span class="font-medium text-slate-900">{{ $faq['q'] }}</span>
                            <span class="transition-transform" :class="openIndex === {{ $i }} ? 'rotate-180' : ''">
                                <x-heroicon-o-chevron-down class="h-4 w-4 flex-shrink-0 text-slate-400" />
                            </span>
                        </button>
                        <div x-show="openIndex === {{ $i }}" x-collapse class="mt-2 text-sm leading-relaxed text-slate-500">
                            {{ $faq['a'] }}
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ============ CTA BAND ============ --}}
    <section class="bg-gradient-to-br from-[#123C69] to-[#0B2A4A] py-16">
        <div class="mx-auto max-w-4xl px-6 text-center lg:px-8">
            <h2 class="font-['Plus_Jakarta_Sans'] text-2xl font-extrabold text-white lg:text-3xl" style="font-family:'Plus Jakarta Sans',sans-serif;">
                Ready for a cleaner space?
            </h2>
            <p class="mt-2 text-blue-100">Get your free, no-obligation quote in under a minute.</p>
            <a href="{{ url('/quote') }}" wire:navigate
               class="mt-6 inline-block rounded-lg bg-[#F6AD37] px-8 py-4 font-semibold text-[#123C69] shadow-lg transition hover:bg-[#f5a01c]">
                Get a Free Quote
            </a>
        </div>
    </section>

    {{-- ============ FOOTER ============ --}}
    <footer class="bg-slate-900 py-12 text-slate-400">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            <div class="flex flex-col items-center justify-between gap-6 sm:flex-row">
                <span class="text-lg font-bold text-white">Citi<span class="text-[#4FD1C5]">Maids</span></span>
                <div class="flex gap-6 text-sm">
                    <a href="{{ url('/services') }}" wire:navigate class="hover:text-white">Services</a>
                    <a href="{{ url('/quote') }}" wire:navigate class="hover:text-white">Get a Quote</a>
                    <a href="{{ url('/#faq') }}" wire:navigate class="hover:text-white">FAQ</a>
                </div>
            </div>
            <p class="mt-8 text-center text-xs text-slate-500">&copy; {{ date('Y') }} CitiMaids. Professional cleaning services in Abu Dhabi.</p>
        </div>
    </footer>

</div>

@livewireScripts
</body>
</html>