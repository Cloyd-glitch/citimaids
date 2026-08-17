{{-- Destination: resources/views/livewire/admin/booking-manager.blade.php --}}

<div>
    <div class="mb-8 flex flex-wrap items-center justify-between gap-4">
        <div>
            <h1 class="font-['Plus_Jakarta_Sans'] text-2xl font-extrabold text-slate-900" style="font-family:'Plus Jakarta Sans',sans-serif;">
                Bookings
            </h1>
            <p class="mt-1 text-sm text-slate-500">View, confirm, and manage every booking.</p>
        </div>

        <input wire:model.live.debounce.400ms="search" type="text" placeholder="Search by name or email…"
               class="w-full max-w-xs rounded-lg border border-slate-200 px-4 py-2.5 text-sm text-slate-700 focus:border-[#123C69] focus:outline-none focus:ring-1 focus:ring-[#123C69]">
    </div>

    {{-- ============ STATUS TABS ============ --}}
    <div class="flex flex-wrap gap-2">
        @foreach ([
            'all' => 'All',
            'pending' => 'Pending',
            'confirmed' => 'Confirmed',
            'completed' => 'Completed',
            'cancelled' => 'Cancelled',
        ] as $value => $label)
            <button type="button" wire:click="$set('statusFilter', '{{ $value }}')"
                    class="flex items-center gap-2 rounded-full px-4 py-2 text-sm font-semibold transition
                           {{ $statusFilter === $value ? 'bg-[#123C69] text-white' : 'bg-white text-slate-600 hover:bg-slate-100' }}">
                {{ $label }}
                <span class="rounded-full px-1.5 py-0.5 text-xs font-bold
                             {{ $statusFilter === $value ? 'bg-white/20' : 'bg-slate-100' }}">
                    {{ $statusCounts[$value] }}
                </span>
            </button>
        @endforeach
    </div>

    {{-- ============ TABLE ============ --}}
    <div class="mt-6 overflow-x-auto rounded-2xl bg-white shadow-sm">
        <table class="w-full text-left text-sm">
            <thead>
                <tr class="border-b border-slate-100 text-xs font-semibold uppercase tracking-wide text-slate-400">
                    <th class="px-6 py-4">Reference</th>
                    <th class="px-6 py-4">Customer</th>
                    <th class="px-6 py-4">Property</th>
                    <th class="px-6 py-4">Schedule</th>
                    <th class="px-6 py-4">Total</th>
                    <th class="px-6 py-4">Status</th>
                    <th class="px-6 py-4">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse ($bookings as $booking)
                    <tr wire:key="booking-{{ $booking->id }}">
                        <td class="px-6 py-4 font-mono text-xs text-slate-500">{{ $booking->reference }}</td>
                        <td class="px-6 py-4">
                            <p class="font-medium text-slate-800">{{ $booking->customer->name }}</p>
                            <p class="text-xs text-slate-400">{{ $booking->customer->email }}</p>
                        </td>
                        <td class="px-6 py-4 text-slate-600">
                            {{ ucfirst($booking->property_type) }} · {{ $booking->rooms }}br/{{ $booking->bathrooms }}ba
                            {{ $booking->deep_clean ? ' · Deep' : '' }}
                        </td>
                        <td class="px-6 py-4 text-slate-600">
                            {{ $booking->scheduled_date->format('M j, Y') }} · {{ $booking->scheduled_time }}
                        </td>
                        <td class="px-6 py-4 font-medium text-slate-800">AED {{ number_format($booking->total, 0) }}</td>
                        <td class="px-6 py-4">
                            <span class="rounded-full px-2.5 py-1 text-xs font-semibold
                                {{ match($booking->status) {
                                    'confirmed' => 'bg-[#4FD1C5]/15 text-[#0f9488]',
                                    'pending' => 'bg-[#F6AD37]/15 text-[#b3791f]',
                                    'completed' => 'bg-slate-100 text-slate-500',
                                    default => 'bg-red-50 text-red-500',
                                } }}">
                                {{ ucfirst($booking->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                @if ($booking->status === 'pending')
                                    <button type="button" wire:click="confirmBooking({{ $booking->id }})"
                                            class="rounded-lg bg-[#123C69] px-3 py-1.5 text-xs font-semibold text-white transition hover:bg-[#0d2c4e]">
                                        Confirm
                                    </button>
                                    <button type="button" wire:click="cancelBooking({{ $booking->id }})"
                                            wire:confirm="Cancel this booking? This can't be undone."
                                            class="rounded-lg border border-slate-200 px-3 py-1.5 text-xs font-semibold text-slate-500 transition hover:bg-slate-50">
                                        Cancel
                                    </button>
                                @elseif ($booking->status === 'confirmed')
                                    <button type="button" wire:click="completeBooking({{ $booking->id }})"
                                            class="rounded-lg bg-[#4FD1C5] px-3 py-1.5 text-xs font-semibold text-[#0f4d47] transition hover:bg-[#3dbdb0]">
                                        Mark Completed
                                    </button>
                                    <button type="button" wire:click="cancelBooking({{ $booking->id }})"
                                            wire:confirm="Cancel this booking? This can't be undone."
                                            class="rounded-lg border border-slate-200 px-3 py-1.5 text-xs font-semibold text-slate-500 transition hover:bg-slate-50">
                                        Cancel
                                    </button>
                                @else
                                    <span class="text-xs text-slate-300">—</span>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-10 text-center text-sm text-slate-400">
                            No bookings match your filters.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $bookings->links() }}
    </div>
</div>