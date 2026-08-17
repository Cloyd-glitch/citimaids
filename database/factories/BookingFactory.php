<?php

namespace Database\Factories;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class BookingFactory extends Factory
{
    public function definition(): array
    {
        $rates = ['apartment' => 35, 'villa' => 45, 'office' => 40];
        $discounts = ['onetime' => 0, 'weekly' => 0.20, 'biweekly' => 0.15, 'monthly' => 0.10];

        $propertyType = fake()->randomElement(['apartment', 'apartment', 'villa', 'office']);
        $rooms = fake()->numberBetween(1, 5);
        $bathrooms = fake()->numberBetween(1, 3);
        $deepClean = fake()->boolean(25);
        $frequency = fake()->randomElement(['onetime', 'onetime', 'onetime', 'weekly', 'biweekly', 'monthly']);

        $hours = max(2, $rooms * 0.75 + $bathrooms * 0.4 + ($deepClean ? 1.5 : 0));
        $base = $hours * $rates[$propertyType];
        $total = round($base - ($base * $discounts[$frequency]));

        // Spread bookings across the past 5 months and a few weeks into the future.
        $scheduledAt = fake()->dateTimeBetween('-5 months', '+3 weeks');
        $isPast = $scheduledAt < now();

        return [
            'customer_id' => Customer::factory(),
            'property_type' => $propertyType,
            'rooms' => $rooms,
            'bathrooms' => $bathrooms,
            'deep_clean' => $deepClean,
            'frequency' => $frequency,
            'scheduled_date' => $scheduledAt->format('Y-m-d'),
            'scheduled_time' => fake()->randomElement(['08:00', '10:00', '12:00', '14:00', '16:00', '18:00']),
            'address' => fake()->streetAddress().', Abu Dhabi',
            'notes' => null,
            'total' => $total,
            'status' => $isPast
                ? fake()->randomElement(['completed', 'completed', 'completed', 'cancelled'])
                : fake()->randomElement(['pending', 'confirmed']),
            'reference' => 'CM-'.strtoupper(Str::random(6)),
        ];
    }
}