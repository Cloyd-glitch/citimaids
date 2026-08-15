{{-- Destination: resources/views/livewire/welcome/quote-calculator.blade.php --}}

{{--
    Reads optional query params to prefill the form on load (all handled client-side
    in the x-init below, so this works whether /quote is a plain route or a Livewire
    full-page component):
      ?type=apartment|villa|office
      ?rooms=2
      ?deep=1
      ?service=deep-cleaning|villa|office|recurring   (from services-list CTAs)
    "Continue to Booking" passes the finished selection to /book via query string —
    booking-wizard.blade.php reads the same keys to prefill its Step 1.
--}}

<div>
    <livewire:welcome.navigation />

    {{-- ============ HERO ============ --}}
    <section class="relative overflow-hidden bg-gradient-to-br from-[#123C69] to-[#0B2A4A] pb-24 pt-32 text-white">
        <div class="pointer-events-none absolute inset-0 opacity-[0.07]"
             style="background-image:radial-gradient(circle,#fff 1px,transparent 1px);background-size:22px 22px;"></div>

        <div class="relative mx-auto max-w-3xl px-6 text-center lg:px-8">
            <span class="inline-flex items-center gap-2 rounded-full bg-white/10 px-4 py-1.5 text-xs font-semibold text-[#4FD1C5] ring-1 ring-white/20">
                <x-heroicon-s-banknotes class="h-3.5 w-3.5" /> Instant Estimate
            </span>

            <h1 class="mt-6 font-['Plus_Jakarta_Sans'] text-4xl font-extrabold leading-tight lg:text-5xl" style="font-family:'Plus Jakarta Sans',sans-serif;">
                What would your clean cost?
            </h1>

            <p class="mt-5 text-lg leading-relaxed text-blue-100">
                Answer a few quick questions — the price updates as you go. No calls, no sign-up.
            </p>
        </div>
    </section>

    {{-- ============ CALCULATOR ============ --}}
    <section class="relative mx-auto -mt-12 max-w-6xl px-6 pb-24 lg:px-8"
        x-data="{
            type: 'apartment',
            rooms: 2,
            bathrooms: 1,
            deep: false,
            frequency: 'onetime',
            extras: { fridge: false, oven: false, windows: false, ironing: false },
            rates: { apartment: 35, villa: 45, office: 40 },
            freqDiscount: { onetime: 0, weekly: 0.20, biweekly: 0.15, monthly: 0.10 },
            extraPrices: { fridge: 15, oven: 15, windows: 20, ironing: 25 },
            get hours() { return Math.max(2, this.rooms * 0.75 + this.bathrooms * 0.4 + (this.deep ? 1.5 : 0)) },
            get baseCost() { return this.hours * this.rates[this.type] },
            get discountAmount() { return this.baseCost * this.freqDiscount[this.frequency] },
            get extrasTotal() { return Object.keys(this.extras).reduce((sum, k) => sum + (this.extras[k] ? this.extraPrices[k] : 0), 0) },
            get total() { return Math.round(this.baseCost - this.discountAmount + this.extrasTotal) },
            init() {
                const params = new URLSearchParams(window.location.search);
                if (params.get('type') && this.rates[params.get('type')]) this.type = params.get('type');
                if (params.get('rooms')) this.rooms = Math.min(10, Math.max(1, parseInt(params.get('rooms')) || 2));
                if (params.get('deep') === '1') this.deep = true;
                const service = params.get('service');
                if (service === 'deep-cleaning' || service === 'move-in-out') this.deep = true;
                if (service === 'villa') this.type = 'villa';
                if (service === 'office') this.type = 'office';
                if (service === 'recurring') this.frequency = 'weekly';
            }
        }"
    >
        <div class="grid gap-8 lg:grid-cols-5 lg:items-start">

            {{-- Left: form --}}
            <div class="rounded-2xl bg-white p-7 shadow-xl lg:col-span-3 lg:p-8">

                {{-- Property type --}}
                <div>
                    <label class="text-xs font-semibold uppercase tracking-wide text-slate-500">Property type</label>
                    <div class="mt-3 grid grid-cols-3 gap-2">
                        <button type="button" @click="type = 'apartment'"
                                class="rounded-lg py-2.5 text-sm font-semibold transition"
                                :class="type === 'apartment' ? 'bg-[#123C69] text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200'">
                            Apartment
                        </button>
                        <button type="button" @click="type = 'villa'"
                                class="rounded-lg py-2.5 text-sm font-semibold transition"
                                :class="type === 'villa' ? 'bg-[#123C69] text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200'">
                            Villa
                        </button>
                        <button type="button" @click="type = 'office'"
                                class="rounded-lg py-2.5 text-sm font-semibold transition"
                                :class="type === 'office' ? 'bg-[#123C69] text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200'">
                            Office
                        </button>
                    </div>
                </div>

                {{-- Rooms / Bathrooms steppers --}}
                <div class="mt-6 grid grid-cols-2 gap-6">
                    <div>
                        <label class="text-xs font-semibold uppercase tracking-wide text-slate-500">Rooms</label>
                        <div class="mt-3 flex items-center gap-3">
                            <button type="button" @click="rooms = Math.max(1, rooms - 1)"
                                    class="grid h-9 w-9 place-items-center rounded-full bg-slate-100 text-slate-600 hover:bg-slate-200">−</button>
                            <span class="w-4 text-center text-sm font-semibold" x-text="rooms"></span>
                            <button type="button" @click="rooms = Math.min(10, rooms + 1)"
                                    class="grid h-9 w-9 place-items-center rounded-full bg-slate-100 text-slate-600 hover:bg-slate-200">+</button>
                        </div>
                    </div>
                    <div>
                        <label class="text-xs font-semibold uppercase tracking-wide text-slate-500">Bathrooms</label>
                        <div class="mt-3 flex items-center gap-3">
                            <button type="button" @click="bathrooms = Math.max(1, bathrooms - 1)"
                                    class="grid h-9 w-9 place-items-center rounded-full bg-slate-100 text-slate-600 hover:bg-slate-200">−</button>
                            <span class="w-4 text-center text-sm font-semibold" x-text="bathrooms"></span>
                            <button type="button" @click="bathrooms = Math.min(6, bathrooms + 1)"
                                    class="grid h-9 w-9 place-items-center rounded-full bg-slate-100 text-slate-600 hover:bg-slate-200">+</button>
                        </div>
                    </div>
                </div>

                {{-- Frequency --}}
                <div class="mt-6">
                    <label class="text-xs font-semibold uppercase tracking-wide text-slate-500">How often?</label>
                    <div class="mt-3 grid grid-cols-2 gap-2">
                        <button type="button" @click="frequency = 'onetime'"
                                class="rounded-lg px-4 py-2.5 text-left text-sm font-semibold transition"
                                :class="frequency === 'onetime' ? 'bg-[#123C69] text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200'">
                            One-time
                        </button>
                        <button type="button" @click="frequency = 'weekly'"
                                class="flex items-center justify-between rounded-lg px-4 py-2.5 text-left text-sm font-semibold transition"
                                :class="frequency === 'weekly' ? 'bg-[#123C69] text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200'">
                            Weekly
                            <span class="rounded-full bg-[#4FD1C5]/20 px-2 py-0.5 text-[10px] font-bold text-[#0f9488]" :class="frequency === 'weekly' ? '!bg-white/20 !text-white' : ''">−20%</span>
                        </button>
                        <button type="button" @click="frequency = 'biweekly'"
                                class="flex items-center justify-between rounded-lg px-4 py-2.5 text-left text-sm font-semibold transition"
                                :class="frequency === 'biweekly' ? 'bg-[#123C69] text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200'">
                            Bi-weekly
                            <span class="rounded-full bg-[#4FD1C5]/20 px-2 py-0.5 text-[10px] font-bold text-[#0f9488]" :class="frequency === 'biweekly' ? '!bg-white/20 !text-white' : ''">−15%</span>
                        </button>
                        <button type="button" @click="frequency = 'monthly'"
                                class="flex items-center justify-between rounded-lg px-4 py-2.5 text-left text-sm font-semibold transition"
                                :class="frequency === 'monthly' ? 'bg-[#123C69] text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200'">
                            Monthly
                            <span class="rounded-full bg-[#4FD1C5]/20 px-2 py-0.5 text-[10px] font-bold text-[#0f9488]" :class="frequency === 'monthly' ? '!bg-white/20 !text-white' : ''">−10%</span>
                        </button>
                    </div>
                </div>

                {{-- Deep clean toggle --}}
                <div class="mt-6 flex items-center justify-between rounded-lg bg-slate-50 px-4 py-3">
                    <div>
                        <p class="text-sm font-semibold text-slate-700">Deep clean</p>
                        <p class="text-xs text-slate-400">A more thorough, top-to-bottom visit</p>
                    </div>
                    <button type="button" @click="deep = !deep"
                            class="relative inline-flex h-6 w-11 flex-shrink-0 items-center rounded-full transition"
                            :class="deep ? 'bg-[#4FD1C5]' : 'bg-slate-200'">
                        <span class="inline-block h-4 w-4 transform rounded-full bg-white transition"
                              :class="deep ? 'translate-x-6' : 'translate-x-1'"></span>
                    </button>
                </div>

                {{-- Extras --}}
                <div class="mt-6">
                    <label class="text-xs font-semibold uppercase tracking-wide text-slate-500">Add extras</label>
                    <div class="mt-3 space-y-2">
                        @foreach ([
                            ['key' => 'fridge', 'label' => 'Inside fridge', 'price' => 15],
                            ['key' => 'oven', 'label' => 'Inside oven', 'price' => 15],
                            ['key' => 'windows', 'label' => 'Interior windows', 'price' => 20],
                            ['key' => 'ironing', 'label' => 'Ironing service', 'price' => 25],
                        ] as $extra)
                            <label class="flex cursor-pointer items-center justify-between rounded-lg border border-slate-200 px-4 py-3 transition hover:border-slate-300">
                                <span class="flex items-center gap-3">
                                    <span class="flex h-5 w-5 items-center justify-center rounded border transition"
                                          :class="extras.{{ $extra['key'] }} ? 'border-[#123C69] bg-[#123C69]' : 'border-slate-300 bg-white'">
                                        <x-heroicon-s-check class="h-3.5 w-3.5 text-white" x-show="extras.{{ $extra['key'] }}" x-cloak />
                                    </span>
                                    <span class="text-sm font-medium text-slate-700">{{ $extra['label'] }}</span>
                                </span>
                                <span class="flex items-center gap-3">
                                    <span class="text-xs text-slate-400">+AED {{ $extra['price'] }}</span>
                                    <input type="checkbox" x-model="extras.{{ $extra['key'] }}" class="sr-only">
                                </span>
                            </label>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Right: sticky summary --}}
            <div class="lg:sticky lg:top-24 lg:col-span-2">
                <div class="rounded-2xl bg-[#123C69] p-7 text-white shadow-2xl">
                    <p class="text-xs font-semibold uppercase tracking-wide text-blue-200">Your estimate</p>
                    <p class="mt-1 font-['Plus_Jakarta_Sans'] text-4xl font-extrabold" style="font-family:'Plus Jakarta Sans',sans-serif;">
                        AED <span x-text="total"></span>
                    </p>
                    <p class="text-xs text-blue-200">≈ <span x-text="hours.toFixed(1)"></span> hrs at AED <span x-text="rates[type]"></span>/hr</p>

                    <div class="mt-5 divide-y divide-white/10 border-t border-white/10 text-sm">
                        <div class="flex items-center justify-between py-2.5">
                            <span class="text-blue-100">Base cost</span>
                            <span class="font-medium" x-text="'AED ' + Math.round(baseCost)"></span>
                        </div>
                        <div class="flex items-center justify-between py-2.5" x-show="discountAmount > 0" x-cloak>
                            <span class="text-blue-100">Frequency discount</span>
                            <span class="font-medium text-[#4FD1C5]" x-text="'−AED ' + Math.round(discountAmount)"></span>
                        </div>
                        <div class="flex items-center justify-between py-2.5" x-show="extrasTotal > 0" x-cloak>
                            <span class="text-blue-100">Extras</span>
                            <span class="font-medium" x-text="'+AED ' + extrasTotal"></span>
                        </div>
                    </div>

                    <a :href="'/book?type=' + type + '&rooms=' + rooms + '&bathrooms=' + bathrooms + '&deep=' + (deep ? 1 : 0) + '&frequency=' + frequency + '&total=' + total"
                       wire:navigate
                       class="mt-6 block rounded-lg bg-[#F6AD37] py-3.5 text-center text-sm font-semibold text-[#123C69] shadow-lg transition hover:bg-[#f5a01c]">
                        Continue to Booking
                    </a>

                    <ul class="mt-5 space-y-2 text-xs text-blue-100">
                        <li class="flex items-center gap-2"><x-heroicon-s-check-circle class="h-3.5 w-3.5 flex-shrink-0 text-[#4FD1C5]" /> No payment required to book</li>
                        <li class="flex items-center gap-2"><x-heroicon-s-check-circle class="h-3.5 w-3.5 flex-shrink-0 text-[#4FD1C5]" /> Free rescheduling, up to 24 hrs before</li>
                        <li class="flex items-center gap-2"><x-heroicon-s-check-circle class="h-3.5 w-3.5 flex-shrink-0 text-[#4FD1C5]" /> Vetted, background-checked cleaners</li>
                    </ul>
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