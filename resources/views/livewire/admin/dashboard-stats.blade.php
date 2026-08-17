{{-- Destination: resources/views/livewire/admin/dashboard-stats.blade.php --}}

<div>
    <div class="mb-8">
        <h1 class="font-['Plus_Jakarta_Sans'] text-2xl font-extrabold text-slate-900" style="font-family:'Plus Jakarta Sans',sans-serif;">
            Dashboard
        </h1>
        <p class="mt-1 text-sm text-slate-500">Here's what's happening with CitiMaids today.</p>
    </div>

    {{-- ============ STAT CARDS ============ --}}
    <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
        <div class="rounded-2xl bg-white p-6 shadow-sm">
            <span class="flex h-10 w-10 items-center justify-center rounded-lg bg-[#123C69]/10 text-[#123C69]">
                <x-heroicon-o-calendar-days class="h-5 w-5" />
            </span>
            <p class="mt-4 text-xs font-semibold uppercase tracking-wide text-slate-400">Total Bookings</p>
            <p class="mt-1 text-3xl font-extrabold text-slate-900">{{ number_format($totalBookings) }}</p>
        </div>

        <div class="rounded-2xl bg-white p-6 shadow-sm">
            <span class="flex h-10 w-10 items-center justify-center rounded-lg bg-[#4FD1C5]/15 text-[#0f9488]">
                <x-heroicon-o-banknotes class="h-5 w-5" />
            </span>
            <p class="mt-4 text-xs font-semibold uppercase tracking-wide text-slate-400">Total Revenue</p>
            <p class="mt-1 text-3xl font-extrabold text-slate-900">AED {{ number_format($totalRevenue, 0) }}</p>
        </div>

        <div class="rounded-2xl bg-white p-6 shadow-sm">
            <span class="flex h-10 w-10 items-center justify-center rounded-lg bg-[#F6AD37]/15 text-[#b3791f]">
                <x-heroicon-o-users class="h-5 w-5" />
            </span>
            <p class="mt-4 text-xs font-semibold uppercase tracking-wide text-slate-400">Customers</p>
            <p class="mt-1 text-3xl font-extrabold text-slate-900">{{ number_format($totalCustomers) }}</p>
        </div>

        <div class="rounded-2xl bg-white p-6 shadow-sm">
            <span class="flex h-10 w-10 items-center justify-center rounded-lg bg-slate-100 text-slate-500">
                <x-heroicon-o-clock class="h-5 w-5" />
            </span>
            <p class="mt-4 text-xs font-semibold uppercase tracking-wide text-slate-400">Upcoming</p>
            <p class="mt-1 text-3xl font-extrabold text-slate-900">{{ number_format($upcomingCount) }}</p>
        </div>
    </div>

    <div class="mt-6 grid gap-6 lg:grid-cols-5">

        {{-- ============ REVENUE CHART ============ --}}
        <div class="rounded-2xl bg-white p-6 shadow-sm lg:col-span-2">
            <p class="text-sm font-semibold text-slate-700">Revenue, last 6 months</p>

            <div class="mt-8 flex items-end justify-between gap-3" style="height: 140px;">
                @foreach ($monthlyRevenue as $month)
                    <div class="flex flex-1 flex-col items-center gap-2">
                        <div class="w-full rounded-t-md bg-[#123C69]"
                             style="height: {{ max(4, (int) round(($month['revenue'] / $maxRevenue) * 120)) }}px;"
                             title="AED {{ number_format($month['revenue'], 0) }}"></div>
                        <span class="text-[11px] font-medium text-slate-400">{{ $month['label'] }}</span>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- ============ UPCOMING BOOKINGS ============ --}}
        <div class="rounded-2xl bg-white p-6 shadow-sm lg:col-span-3">
            <div class="flex items-center justify-between">
                <p class="text-sm font-semibold text-slate-700">Upcoming bookings</p>
                <a href="{{ route('admin.bookings') }}" wire:navigate class="text-xs font-semibold text-[#123C69] hover:underline">
                    View all →
                </a>
            </div>

            <div class="mt-4 overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead>
                        <tr class="border-b border-slate-100 text-xs font-semibold uppercase tracking-wide text-slate-400">
                            <th class="pb-3 pr-4">Customer</th>
                            <th class="pb-3 pr-4">Property</th>
                            <th class="pb-3 pr-4">Date</th>
                            <th class="pb-3 pr-4">Total</th>
                            <th class="pb-3">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($upcomingBookings as $booking)
                            <tr>
                                <td class="py-3 pr-4">
                                    <p class="font-medium text-slate-800">{{ $booking->customer->name }}</p>
                                    <p class="text-xs text-slate-400">{{ $booking->customer->email }}</p>
                                </td>
                                <td class="py-3 pr-4 text-slate-600">
                                    {{ ucfirst($booking->property_type) }}{{ $booking->deep_clean ? ' · Deep' : '' }}
                                </td>
                                <td class="py-3 pr-4 text-slate-600">
                                    {{ $booking->scheduled_date->format('M j') }} · {{ $booking->scheduled_time }}
                                </td>
                                <td class="py-3 pr-4 font-medium text-slate-800">
                                    AED {{ number_format($booking->total, 0) }}
                                </td>
                                <td class="py-3">
                                    <span class="rounded-full px-2.5 py-1 text-xs font-semibold
                                        {{ match($booking->status) {
                                            'confirmed' => 'bg-[#4FD1C5]/15 text-[#0f9488]',
                                            'pending' => 'bg-[#F6AD37]/15 text-[#b3791f]',
                                            default => 'bg-slate-100 text-slate-500',
                                        } }}">
                                        {{ ucfirst($booking->status) }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-8 text-center text-sm text-slate-400">
                                    No upcoming bookings yet.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>