{{-- Destination: resources/views/livewire/welcome/services-list.blade.php --}}

<div>
    <livewire:welcome.navigation />

    {{-- ============ HERO ============ --}}
    <section class="relative overflow-hidden bg-gradient-to-br from-[#123C69] to-[#0B2A4A] pb-20 pt-32 text-white">
        <div class="pointer-events-none absolute inset-0 opacity-[0.07]"
             style="background-image:radial-gradient(circle,#fff 1px,transparent 1px);background-size:22px 22px;"></div>

        <div class="relative mx-auto max-w-3xl px-6 text-center lg:px-8">
            <span class="inline-flex items-center gap-2 rounded-full bg-white/10 px-4 py-1.5 text-xs font-semibold text-[#4FD1C5] ring-1 ring-white/20">
                <x-heroicon-s-sparkles class="h-3.5 w-3.5" /> What We Offer
            </span>

            <h1 class="mt-6 font-['Plus_Jakarta_Sans'] text-4xl font-extrabold leading-tight lg:text-5xl" style="font-family:'Plus Jakarta Sans',sans-serif;">
                Every space, one standard of clean.
            </h1>

            <p class="mt-5 text-lg leading-relaxed text-blue-100">
                From weekly apartment upkeep to full villa resets — pick the service that fits, then get an instant price.
            </p>
        </div>
    </section>

    {{-- ============ FILTER + GRID ============ --}}
    <section class="mx-auto max-w-7xl px-6 py-20 lg:px-8" x-data="{ active: 'all' }">
        <div class="flex flex-wrap justify-center gap-2">
            <button type="button" @click="active = 'all'"
                    class="rounded-full px-5 py-2 text-sm font-semibold transition"
                    :class="active === 'all' ? 'bg-[#123C69] text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200'">
                All Services
            </button>
            <button type="button" @click="active = 'home'"
                    class="rounded-full px-5 py-2 text-sm font-semibold transition"
                    :class="active === 'home' ? 'bg-[#123C69] text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200'">
                Home
            </button>
            <button type="button" @click="active = 'business'"
                    class="rounded-full px-5 py-2 text-sm font-semibold transition"
                    :class="active === 'business' ? 'bg-[#123C69] text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200'">
                Business
            </button>
            <button type="button" @click="active = 'specialty'"
                    class="rounded-full px-5 py-2 text-sm font-semibold transition"
                    :class="active === 'specialty' ? 'bg-[#123C69] text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200'">
                Specialty
            </button>
        </div>

        <div class="mt-12 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ([
                [
                    'icon' => 'heroicon-o-home', 'category' => 'home', 'slug' => 'residential',
                    'title' => 'Residential Cleaning', 'desc' => 'Regular upkeep for apartments and family homes.',
                    'features' => ['Kitchen & bathroom wipe-down', 'Dusting & vacuuming, every room', 'Eco-friendly supplies included'],
                    'price' => 'From AED 35/hr',
                ],
                [
                    'icon' => 'heroicon-o-building-office-2', 'category' => 'business', 'slug' => 'office',
                    'title' => 'Office Cleaning', 'desc' => 'Scheduled cleaning that keeps workplaces presentable.',
                    'features' => ['Desks & common areas sanitized', 'Flexible after-hours scheduling', 'Recurring contracts available'],
                    'price' => 'From AED 40/hr',
                ],
                [
                    'icon' => 'heroicon-o-sparkles', 'category' => 'specialty', 'slug' => 'deep-cleaning',
                    'title' => 'Deep Cleaning', 'desc' => 'A thorough top-to-bottom reset, room by room.',
                    'features' => ['Inside cabinets, ovens & fridges', 'Grout, tile & baseboard scrub', 'Ideal before move-in or events'],
                    'price' => 'From AED 50/hr',
                ],
                [
                    'icon' => 'heroicon-o-home-modern', 'category' => 'home', 'slug' => 'villa',
                    'title' => 'Villa Cleaning', 'desc' => 'Full-property teams for larger homes and villas.',
                    'features' => ['Full-property team dispatch', 'Multi-floor & outdoor areas', 'Dedicated team lead on site'],
                    'price' => 'From AED 45/hr',
                ],
                [
                    'icon' => 'heroicon-o-truck', 'category' => 'specialty', 'slug' => 'move-in-out',
                    'title' => 'Move-in / Move-out', 'desc' => 'A spotless handover for tenants, landlords, and buyers.',
                    'features' => ['Empty-property top-to-bottom reset', 'Landlord & tenant handover ready', 'Same-day availability'],
                    'price' => 'From AED 55/hr',
                ],
                [
                    'icon' => 'heroicon-o-arrow-path', 'category' => 'business', 'slug' => 'recurring',
                    'title' => 'Recurring Plans', 'desc' => 'Weekly or bi-weekly visits with the same trusted cleaner.',
                    'features' => ['Same trusted cleaner, every visit', 'Weekly, bi-weekly or monthly', 'Pause or reschedule anytime'],
                    'price' => 'Save up to 20%',
                ],
            ] as $service)
                <div
                    x-show="active === 'all' || active === '{{ $service['category'] }}'"
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0"
                    x-transition:enter-end="opacity-100"
                    class="group flex flex-col rounded-2xl border border-slate-100 bg-white p-6 shadow-sm transition hover:-translate-y-1 hover:shadow-lg"
                >
                    <div class="flex items-start justify-between">
                        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-[#123C69]/10 text-[#123C69] transition group-hover:bg-[#123C69] group-hover:text-white">
                            <x-dynamic-component :component="$service['icon']" class="h-6 w-6" />
                        </div>
                        <span class="rounded-full bg-slate-50 px-3 py-1 text-xs font-semibold text-slate-500">{{ $service['price'] }}</span>
                    </div>

                    <h3 class="mt-4 font-semibold text-slate-900">{{ $service['title'] }}</h3>
                    <p class="mt-1.5 text-sm leading-relaxed text-slate-500">{{ $service['desc'] }}</p>

                    <ul class="mt-4 space-y-2 border-t border-slate-100 pt-4">
                        @foreach ($service['features'] as $feature)
                            <li class="flex items-start gap-2 text-xs text-slate-500">
                                <x-heroicon-s-check-circle class="mt-0.5 h-3.5 w-3.5 flex-shrink-0 text-[#4FD1C5]" />
                                {{ $feature }}
                            </li>
                        @endforeach
                    </ul>

                    <a href="{{ url('/quote') }}?service={{ $service['slug'] }}" wire:navigate
                       class="mt-5 inline-flex items-center gap-1.5 text-sm font-semibold text-[#123C69] transition-all hover:gap-2.5">
                        Get a Quote <x-heroicon-o-arrow-right class="h-3.5 w-3.5" />
                    </a>
                </div>
            @endforeach
        </div>
    </section>

    {{-- ============ NOT SURE? CTA ============ --}}
    <section class="bg-white py-20">
        <div class="mx-auto grid max-w-6xl gap-10 px-6 lg:grid-cols-2 lg:items-center lg:px-8">
            <div>
                <p class="text-sm font-semibold uppercase tracking-wide text-[#123C69]">Still deciding?</p>
                <h2 class="mt-2 font-['Plus_Jakarta_Sans'] text-3xl font-extrabold text-slate-900" style="font-family:'Plus Jakarta Sans',sans-serif;">
                    Not sure which service fits?
                </h2>
                <ul class="mt-6 space-y-3 text-sm text-slate-600">
                    <li class="flex items-center gap-2"><x-heroicon-s-check-circle class="h-4 w-4 text-[#4FD1C5]" /> Instant estimate, no sign-up needed</li>
                    <li class="flex items-center gap-2"><x-heroicon-s-check-circle class="h-4 w-4 text-[#4FD1C5]" /> No hidden fees or call-out charges</li>
                    <li class="flex items-center gap-2"><x-heroicon-s-check-circle class="h-4 w-4 text-[#4FD1C5]" /> Free cancellation up to 24 hours before</li>
                </ul>
            </div>

            <div class="rounded-2xl bg-slate-50 p-8 text-center">
                <x-heroicon-o-chat-bubble-left-right class="mx-auto h-8 w-8 text-[#123C69]" />
                <p class="mt-3 font-semibold text-slate-900">Talk it through with us</p>
                <p class="mt-1 text-sm text-slate-500">Our team can recommend the right plan in under a minute.</p>
                <div class="mt-6 flex flex-col gap-3 sm:flex-row sm:justify-center">
                    <a href="{{ url('/quote') }}" wire:navigate
                       class="rounded-lg bg-[#F6AD37] px-6 py-3 text-sm font-semibold text-[#123C69] shadow-sm transition hover:bg-[#f5a01c]">
                        Get a Free Quote
                    </a>
                    <a href="tel:+971800000000"
                       class="rounded-lg border border-slate-200 px-6 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-100">
                        Call Us
                    </a>
                </div>
            </div>
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