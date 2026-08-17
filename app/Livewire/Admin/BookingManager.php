<?php

namespace App\Livewire\Admin;

use App\Models\Booking;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.admin')]
class BookingManager extends Component
{
    use WithPagination;
    public string $search = '';
    public string $statusFilter = 'all'; // all | pending | confirmed | completed | cancelled

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingStatusFilter(): void
    {
        $this->resetPage();
    }

    public function confirmBooking(int $bookingId): void
    {
        Booking::whereKey($bookingId)->update(['status' => 'confirmed']);
    }

    public function completeBooking(int $bookingId): void
    {
        Booking::whereKey($bookingId)->update(['status' => 'completed']);
    }

    public function cancelBooking(int $bookingId): void
    {
        Booking::whereKey($bookingId)->update(['status' => 'cancelled']);
    }

    public function render()
    {
        $bookings = Booking::query()
            ->with('customer')
            ->when($this->search !== '', function ($query) {
                $query->whereHas('customer', function ($q) {
                    $q->where('name', 'like', "%{$this->search}%")
                        ->orWhere('email', 'like', "%{$this->search}%");
                });
            })
            ->when($this->statusFilter !== 'all', function ($query) {
                $query->where('status', $this->statusFilter);
            })
            ->orderByDesc('scheduled_date')
            ->orderByDesc('id')
            ->paginate(10);

        $statusCounts = [
            'all' => Booking::count(),
            'pending' => Booking::where('status', 'pending')->count(),
            'confirmed' => Booking::where('status', 'confirmed')->count(),
            'completed' => Booking::where('status', 'completed')->count(),
            'cancelled' => Booking::where('status', 'cancelled')->count(),
        ];

        return view('livewire.admin.booking-manager', [
            'bookings' => $bookings,
            'statusCounts' => $statusCounts,
        ]);
    }
}