{{-- Destination: resources/views/livewire/welcome/booking-wizard.blade.php --}}

{{--
    This view assumes a Livewire component class exposing the contract below —
    wire it up to match your Booking model. Everything here (wire:model,
    wire:click, @error) is written against these names.

    Public properties:
        int     $step            = 1        // 1 Property, 2 Schedule, 3 Details, 4 Review
        int     $maxStepReached   = 1        // lets goToStep() re-open completed steps only
        string  $propertyType     = 'apartment'   // apartment | villa | office
        int     $rooms            = 2
        int     $bathrooms        = 1
        bool    $deepClean        = false
        string  $frequency        = 'onetime'      // onetime | weekly | biweekly | monthly
        ?string $date             = null
        ?string $time             = null
        string  $name             = ''
        string  $email            = ''
        string  $phone            = ''
        string  $address          = ''
        ?string $notes            = null
        bool    $agreeTerms       = false
        bool    $submitted        = false
        ?string $bookingReference = null

    Methods:
        nextStep(), previousStep(), goToStep(int $step)
        incrementRooms(), decrementRooms(), incrementBathrooms(), decrementBathrooms()
        toggleDeepClean()
        estimatedHours(): float   estimatedTotal(): float   (used below via $this->)
        submit()  // validates step 3 fields + agreeTerms, persists the booking,
                  // sets $submitted = true and $bookingReference

    mount() should read request()->query() for type/rooms/bathrooms/deep/frequency/total
    to prefill from the quote calculator's "Continue to Booking" link.
--}}

<div>
    <livewire:welcome.navigation />

    {{-- ============ HERO ============ --}}
    <section class="relative overflow-hidden bg-gradient-to-br from-[#123C69] to-[#0B2A4A] pb-16 pt-32 text-white">
        <div class="pointer-events-none absolute inset-0 opacity-[0.07]"
             style="background-image:radial-gradient(circle,#fff 1px,transparent 1px);background-size:22px 22px;"></div>

        <div class="relative mx-auto max-w-3xl px-6 text-center lg:px-8">
            <span class="inline-flex items-center gap-2 rounded-full bg-white/10 px-4 py-1.5 text-xs font-semibold text-[#4FD1C5] ring-1 ring-white/20">
                <x-heroicon-s-calendar-days class="h-3.5 w-3.5" /> Book Your Clean
            </span>
            <h1 class="mt-6 font-['Plus_Jakarta_Sans'] text-4xl font-extrabold leading-tight lg:text-5xl" style="font-family:'Plus Jakarta Sans',sans-serif;">
                Let's lock in your visit.
            </h1>
            <p class="mt-5 text-lg leading-relaxed text-blue-100">
                Takes about two minutes — no payment needed to reserve your slot.
            </p>
        </div>
    </section>

    <section class="relative mx-auto -mt-10 max-w-3xl px-6 pb-24 lg:px-8">

        {{-- ============ STEPPER ============ --}}
        <div class="mb-8 rounded-2xl bg-white p-5 shadow-xl" @if($submitted) style="display:none" @endif>
            <div class="flex items-center">
                @foreach ([1 => 'Property', 2 => 'Schedule', 3 => 'Details', 4 => 'Review'] as $n => $label)
                    <button type="button"
                            wire:click="goToStep({{ $n }})"
                            @if ($n > $maxStepReached) disabled @endif
                            class="flex flex-col items-center gap-2 {{ $n < 4 ? 'flex-1' : '' }}"
                    >
                        <span class="flex h-9 w-9 items-center justify-center rounded-full text-sm font-semibold transition
                            {{ $step === $n ? 'bg-[#123C69] text-white' : ($n < $step ? 'bg-[#4FD1C5] text-[#123C69]' : 'bg-slate-100 text-slate-400') }}">
                            @if ($n < $step)
                                <x-heroicon-s-check class="h-4 w-4" />
                            @else
                                {{ $n }}
                            @endif
                        </span>
                        <span class="hidden text-[11px] font-medium sm:block {{ $step === $n ? 'text-[#123C69]' : 'text-slate-400' }}">
                            {{ $label }}
                        </span>
                    </button>
                    @if ($n < 4)
                        <span class="mx-1 h-0.5 flex-1 rounded {{ $n < $step ? 'bg-[#4FD1C5]' : 'bg-slate-100' }}"></span>
                    @endif
                @endforeach
            </div>
        </div>

        {{-- ============ SUCCESS STATE ============ --}}
        @if ($submitted)
            <div class="rounded-2xl bg-white p-10 text-center shadow-xl">
                <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-[#4FD1C5]/15">
                    <x-heroicon-s-check-circle class="h-9 w-9 text-[#0f9488]" />
                </div>
                <h2 class="mt-6 font-['Plus_Jakarta_Sans'] text-2xl font-extrabold text-slate-900" style="font-family:'Plus Jakarta Sans',sans-serif;">
                    Booking confirmed!
                </h2>
                <p class="mt-2 text-sm text-slate-500">
                    Reference <span class="font-semibold text-slate-700">{{ $bookingReference ?? '—' }}</span>.
                    We've sent the details to {{ $email }}.
                </p>
                <a href="{{ url('/') }}" wire:navigate
                   class="mt-8 inline-block rounded-lg bg-[#123C69] px-8 py-3 text-sm font-semibold text-white transition hover:bg-[#0d2c4e]">
                    Back to Home
                </a>
            </div>
        @else

            <div class="rounded-2xl bg-white p-7 shadow-xl lg:p-8">

                {{-- ===== STEP 1: PROPERTY & SERVICE ===== --}}
                @if ($step === 1)
                    <div>
                        <h2 class="font-['Plus_Jakarta_Sans'] text-xl font-bold text-slate-900" style="font-family:'Plus Jakarta Sans',sans-serif;">Property & service</h2>
                        <p class="mt-1 text-sm text-slate-500">Tell us a bit about the space.</p>

                        <div class="mt-6">
                            <label class="text-xs font-semibold uppercase tracking-wide text-slate-500">Property type</label>
                            <div class="mt-3 grid grid-cols-3 gap-2">
                                @foreach (['apartment' => 'Apartment', 'villa' => 'Villa', 'office' => 'Office'] as $value => $label)
                                    <button type="button" wire:click="$set('propertyType', '{{ $value }}')"
                                            class="rounded-lg py-2.5 text-sm font-semibold transition {{ $propertyType === $value ? 'bg-[#123C69] text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                                        {{ $label }}
                                    </button>
                                @endforeach
                            </div>
                        </div>

                        <div class="mt-6 grid grid-cols-2 gap-6">
                            <div>
                                <label class="text-xs font-semibold uppercase tracking-wide text-slate-500">Rooms</label>
                                <div class="mt-3 flex items-center gap-3">
                                    <button type="button" wire:click="decrementRooms" class="grid h-9 w-9 place-items-center rounded-full bg-slate-100 text-slate-600 hover:bg-slate-200">−</button>
                                    <span class="w-4 text-center text-sm font-semibold">{{ $rooms }}</span>
                                    <button type="button" wire:click="incrementRooms" class="grid h-9 w-9 place-items-center rounded-full bg-slate-100 text-slate-600 hover:bg-slate-200">+</button>
                                </div>
                            </div>
                            <div>
                                <label class="text-xs font-semibold uppercase tracking-wide text-slate-500">Bathrooms</label>
                                <div class="mt-3 flex items-center gap-3">
                                    <button type="button" wire:click="decrementBathrooms" class="grid h-9 w-9 place-items-center rounded-full bg-slate-100 text-slate-600 hover:bg-slate-200">−</button>
                                    <span class="w-4 text-center text-sm font-semibold">{{ $bathrooms }}</span>
                                    <button type="button" wire:click="incrementBathrooms" class="grid h-9 w-9 place-items-center rounded-full bg-slate-100 text-slate-600 hover:bg-slate-200">+</button>
                                </div>
                            </div>
                        </div>

                        <div class="mt-6">
                            <label class="text-xs font-semibold uppercase tracking-wide text-slate-500">How often?</label>
                            <div class="mt-3 grid grid-cols-2 gap-2 sm:grid-cols-4">
                                @foreach (['onetime' => 'One-time', 'weekly' => 'Weekly', 'biweekly' => 'Bi-weekly', 'monthly' => 'Monthly'] as $value => $label)
                                    <button type="button" wire:click="$set('frequency', '{{ $value }}')"
                                            class="rounded-lg py-2.5 text-sm font-semibold transition {{ $frequency === $value ? 'bg-[#123C69] text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                                        {{ $label }}
                                    </button>
                                @endforeach
                            </div>
                        </div>

                        <div class="mt-6 flex items-center justify-between rounded-lg bg-slate-50 px-4 py-3">
                            <div>
                                <p class="text-sm font-semibold text-slate-700">Deep clean</p>
                                <p class="text-xs text-slate-400">A more thorough, top-to-bottom visit</p>
                            </div>
                            <button type="button" wire:click="toggleDeepClean"
                                    class="relative inline-flex h-6 w-11 flex-shrink-0 items-center rounded-full transition {{ $deepClean ? 'bg-[#4FD1C5]' : 'bg-slate-200' }}">
                                <span class="inline-block h-4 w-4 transform rounded-full bg-white transition {{ $deepClean ? 'translate-x-6' : 'translate-x-1' }}"></span>
                            </button>
                        </div>
                    </div>
                @endif

                {{-- ===== STEP 2: SCHEDULE ===== --}}
                @if ($step === 2)
                    <div>
                        <h2 class="font-['Plus_Jakarta_Sans'] text-xl font-bold text-slate-900" style="font-family:'Plus Jakarta Sans',sans-serif;">Pick a date & time</h2>
                        <p class="mt-1 text-sm text-slate-500">
                            @if ($frequency !== 'onetime')
                                We'll schedule this as your first {{ $frequency === 'weekly' ? 'weekly' : ($frequency === 'biweekly' ? 'bi-weekly' : 'monthly') }} visit.
                            @else
                                Choose whatever works best for you.
                            @endif
                        </p>

                        <div class="mt-6">
                            <label for="date" class="text-xs font-semibold uppercase tracking-wide text-slate-500">Date</label>
                            <input type="date" id="date" wire:model.live="date" min="{{ now()->format('Y-m-d') }}"
                                   class="mt-2 w-full rounded-lg border border-slate-200 px-4 py-3 text-sm text-slate-700 focus:border-[#123C69] focus:outline-none focus:ring-1 focus:ring-[#123C69]">
                            @error('date') <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p> @enderror
                        </div>

                        <div class="mt-6">
                            <label class="text-xs font-semibold uppercase tracking-wide text-slate-500">Time slot</label>
                            <div class="mt-3 grid grid-cols-3 gap-2">
                                @foreach (['08:00', '10:00', '12:00', '14:00', '16:00', '18:00'] as $slot)
                                    <button type="button" wire:click="$set('time', '{{ $slot }}')"
                                            class="flex items-center justify-center gap-1.5 rounded-lg py-2.5 text-sm font-semibold transition {{ $time === $slot ? 'bg-[#123C69] text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                                        <x-heroicon-o-clock class="h-3.5 w-3.5" /> {{ $slot }}
                                    </button>
                                @endforeach
                            </div>
                            @error('time') <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p> @enderror
                        </div>
                    </div>
                @endif

                {{-- ===== STEP 3: YOUR DETAILS ===== --}}
                @if ($step === 3)
                    <div>
                        <h2 class="font-['Plus_Jakarta_Sans'] text-xl font-bold text-slate-900" style="font-family:'Plus Jakarta Sans',sans-serif;">Your details</h2>
                        <p class="mt-1 text-sm text-slate-500">So your cleaner knows where to go.</p>

                        <div class="mt-6 grid gap-5 sm:grid-cols-2">
                            <div>
                                <label for="name" class="text-xs font-semibold uppercase tracking-wide text-slate-500">Full name</label>
                                <input type="text" id="name" wire:model.blur="name" placeholder="Jane Doe"
                                       class="mt-2 w-full rounded-lg border border-slate-200 px-4 py-3 text-sm text-slate-700 focus:border-[#123C69] focus:outline-none focus:ring-1 focus:ring-[#123C69]">
                                @error('name') <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label for="phone" class="text-xs font-semibold uppercase tracking-wide text-slate-500">Phone</label>
                                <input type="tel" id="phone" wire:model.blur="phone" placeholder="+971 5X XXX XXXX"
                                       class="mt-2 w-full rounded-lg border border-slate-200 px-4 py-3 text-sm text-slate-700 focus:border-[#123C69] focus:outline-none focus:ring-1 focus:ring-[#123C69]">
                                @error('phone') <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div class="mt-5">
                            <label for="email" class="text-xs font-semibold uppercase tracking-wide text-slate-500">Email</label>
                            <input type="email" id="email" wire:model.blur="email" placeholder="jane@example.com"
                                   class="mt-2 w-full rounded-lg border border-slate-200 px-4 py-3 text-sm text-slate-700 focus:border-[#123C69] focus:outline-none focus:ring-1 focus:ring-[#123C69]">
                            @error('email') <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p> @enderror
                        </div>

                        <div class="mt-5">
                            <label for="address" class="text-xs font-semibold uppercase tracking-wide text-slate-500">Address</label>
                            <textarea id="address" wire:model.blur="address" rows="2" placeholder="Building, street, area"
                                      class="mt-2 w-full rounded-lg border border-slate-200 px-4 py-3 text-sm text-slate-700 focus:border-[#123C69] focus:outline-none focus:ring-1 focus:ring-[#123C69]"></textarea>
                            @error('address') <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p> @enderror
                        </div>

                        <div class="mt-5">
                            <label for="notes" class="text-xs font-semibold uppercase tracking-wide text-slate-500">Notes <span class="normal-case text-slate-400">(optional)</span></label>
                            <textarea id="notes" wire:model.blur="notes" rows="2" placeholder="Gate code, pets, anything else we should know"
                                      class="mt-2 w-full rounded-lg border border-slate-200 px-4 py-3 text-sm text-slate-700 focus:border-[#123C69] focus:outline-none focus:ring-1 focus:ring-[#123C69]"></textarea>
                        </div>
                    </div>
                @endif

                {{-- ===== STEP 4: REVIEW & CONFIRM ===== --}}
                @if ($step === 4)
                    <div>
                        <h2 class="font-['Plus_Jakarta_Sans'] text-xl font-bold text-slate-900" style="font-family:'Plus Jakarta Sans',sans-serif;">Review & confirm</h2>
                        <p class="mt-1 text-sm text-slate-500">Take a last look before we lock it in.</p>

                        <dl class="mt-6 divide-y divide-slate-100 rounded-xl bg-slate-50 px-5">
                            <div class="flex items-center justify-between py-3 text-sm">
                                <dt class="text-slate-500">Property</dt>
                                <dd class="font-medium text-slate-800">{{ ucfirst($propertyType) }} · {{ $rooms }} rooms · {{ $bathrooms }} baths{{ $deepClean ? ' · Deep clean' : '' }}</dd>
                            </div>
                            <div class="flex items-center justify-between py-3 text-sm">
                                <dt class="text-slate-500">Frequency</dt>
                                <dd class="font-medium text-slate-800">{{ ucfirst($frequency === 'onetime' ? 'one-time' : $frequency) }}</dd>
                            </div>
                            <div class="flex items-center justify-between py-3 text-sm">
                                <dt class="text-slate-500">Schedule</dt>
                                <dd class="font-medium text-slate-800">{{ $date ?? '—' }}{{ $time ? ' at ' . $time : '' }}</dd>
                            </div>
                            <div class="flex items-center justify-between py-3 text-sm">
                                <dt class="text-slate-500">Contact</dt>
                                <dd class="text-right font-medium text-slate-800">{{ $name ?: '—' }}<br><span class="text-xs font-normal text-slate-400">{{ $email }} · {{ $phone }}</span></dd>
                            </div>
                            <div class="flex items-center justify-between py-3 text-sm">
                                <dt class="text-slate-500">Address</dt>
                                <dd class="max-w-[60%] text-right font-medium text-slate-800">{{ $address ?: '—' }}</dd>
                            </div>
                        </dl>

                        <div class="mt-5 rounded-xl bg-[#123C69] p-5 text-white">
                            <p class="text-xs font-semibold uppercase tracking-wide text-blue-200">Total</p>
                            <p class="mt-1 font-['Plus_Jakarta_Sans'] text-3xl font-extrabold" style="font-family:'Plus Jakarta Sans',sans-serif;">
                                AED {{ number_format($this->estimatedTotal(), 0) }}
                            </p>
                        </div>

                        <label class="mt-5 flex items-start gap-3">
                            <input type="checkbox" wire:model="agreeTerms" class="mt-0.5 h-4 w-4 rounded border-slate-300 text-[#123C69] focus:ring-[#123C69]">
                            <span class="text-xs leading-relaxed text-slate-500">
                                I agree to the <a href="{{ url('/terms') }}" wire:navigate class="font-medium text-[#123C69] underline">terms of service</a> and cancellation policy.
                            </span>
                        </label>
                        @error('agreeTerms') <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>
                @endif

                {{-- ===== NAV BUTTONS ===== --}}
                <div class="mt-8 flex items-center justify-between border-t border-slate-100 pt-6">
                    <button type="button" wire:click="previousStep"
                            class="inline-flex items-center gap-1.5 text-sm font-semibold text-slate-500 transition hover:text-slate-700 {{ $step === 1 ? 'invisible' : '' }}">
                        <x-heroicon-o-arrow-left class="h-3.5 w-3.5" /> Back
                    </button>

                    @if ($step < 4)
                        <button type="button" wire:click="nextStep"
                                class="inline-flex items-center gap-1.5 rounded-lg bg-[#123C69] px-7 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-[#0d2c4e]">
                            Continue <x-heroicon-o-arrow-right class="h-3.5 w-3.5" />
                        </button>
                    @else
                        <button type="button" wire:click="submit" wire:loading.attr="disabled" @if (! $agreeTerms) disabled @endif
                                class="inline-flex items-center gap-1.5 rounded-lg bg-[#F6AD37] px-7 py-3 text-sm font-semibold text-[#123C69] shadow-sm transition hover:bg-[#f5a01c] disabled:cursor-not-allowed disabled:opacity-50">
                            <span wire:loading.remove wire:target="submit">Confirm Booking</span>
                            <span wire:loading wire:target="submit">Confirming…</span>
                        </button>
                    @endif
                </div>
            </div>
        @endif
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