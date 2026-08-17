<?php

namespace App\Livewire\Admin;

use App\Models\Booking;
use App\Models\Customer;
use Illuminate\Support\Carbon;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.admin')]
class DashboardStats extends Component
{
    public function render()
    {
        $totalBookings = Booking::count();
        $totalRevenue = Booking::where('status', '!=', 'cancelled')->sum('total');
        $totalCustomers = Customer::count();

        $upcomingBookings = Booking::with('customer')
            ->where('scheduled_date', '>=', now()->toDateString())
            ->whereIn('status', ['pending', 'confirmed'])
            ->orderBy('scheduled_date')
            ->orderBy('scheduled_time')
            ->limit(8)
            ->get();

        $upcomingCount = Booking::where('scheduled_date', '>=', now()->toDateString())
            ->whereIn('status', ['pending', 'confirmed'])
            ->count();

        // Revenue per month, most recent 6 months.
        $monthlyRevenue = collect(range(5, 0))->map(function (int $monthsAgo) {
            $month = now()->subMonths($monthsAgo);

            $revenue = Booking::where('status', '!=', 'cancelled')
                ->whereYear('scheduled_date', $month->year)
                ->whereMonth('scheduled_date', $month->month)
                ->sum('total');

            return [
                'label' => $month->format('M'),
                'revenue' => (float) $revenue,
            ];
        });

        $maxRevenue = max($monthlyRevenue->max('revenue'), 1);

        return view('livewire.admin.dashboard-stats', [
            'totalBookings' => $totalBookings,
            'totalRevenue' => $totalRevenue,
            'totalCustomers' => $totalCustomers,
            'upcomingCount' => $upcomingCount,
            'upcomingBookings' => $upcomingBookings,
            'monthlyRevenue' => $monthlyRevenue,
            'maxRevenue' => $maxRevenue,
        ]);
    }
}