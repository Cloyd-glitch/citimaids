<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\Customer;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(ServiceSeeder::class);

        // 20 demo customers, each with 1-3 bookings spread across recent
        // months plus a few weeks into the future, so the dashboard has
        // real revenue history and an upcoming-bookings list to show.
        Customer::factory(20)->create()->each(function (Customer $customer) {
            Booking::factory(fake()->numberBetween(1, 3))->create([
                'customer_id' => $customer->id,
            ]);
        });
    }
}