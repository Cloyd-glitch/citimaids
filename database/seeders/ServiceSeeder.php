<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            [
                'name' => 'Residential Cleaning', 'slug' => 'residential', 'category' => 'home',
                'icon' => 'heroicon-o-home', 'description' => 'Regular upkeep for apartments and family homes.',
                'features' => ['Kitchen & bathroom wipe-down', 'Dusting & vacuuming, every room', 'Eco-friendly supplies included'],
                'base_rate' => 35,
            ],
            [
                'name' => 'Office Cleaning', 'slug' => 'office', 'category' => 'business',
                'icon' => 'heroicon-o-building-office-2', 'description' => 'Scheduled cleaning that keeps workplaces presentable.',
                'features' => ['Desks & common areas sanitized', 'Flexible after-hours scheduling', 'Recurring contracts available'],
                'base_rate' => 40,
            ],
            [
                'name' => 'Deep Cleaning', 'slug' => 'deep-cleaning', 'category' => 'specialty',
                'icon' => 'heroicon-o-sparkles', 'description' => 'A thorough top-to-bottom reset, room by room.',
                'features' => ['Inside cabinets, ovens & fridges', 'Grout, tile & baseboard scrub', 'Ideal before move-in or events'],
                'base_rate' => 50,
            ],
            [
                'name' => 'Villa Cleaning', 'slug' => 'villa', 'category' => 'home',
                'icon' => 'heroicon-o-home-modern', 'description' => 'Full-property teams for larger homes and villas.',
                'features' => ['Full-property team dispatch', 'Multi-floor & outdoor areas', 'Dedicated team lead on site'],
                'base_rate' => 45,
            ],
            [
                'name' => 'Move-in / Move-out', 'slug' => 'move-in-out', 'category' => 'specialty',
                'icon' => 'heroicon-o-truck', 'description' => 'A spotless handover for tenants, landlords, and buyers.',
                'features' => ['Empty-property top-to-bottom reset', 'Landlord & tenant handover ready', 'Same-day availability'],
                'base_rate' => 55,
            ],
            [
                'name' => 'Recurring Plans', 'slug' => 'recurring', 'category' => 'business',
                'icon' => 'heroicon-o-arrow-path', 'description' => 'Weekly or bi-weekly visits with the same trusted cleaner — save up to 20%.',
                'features' => ['Same trusted cleaner, every visit', 'Weekly, bi-weekly or monthly', 'Pause or reschedule anytime'],
                'base_rate' => 35,
            ],
        ];

        foreach ($services as $service) {
            Service::updateOrCreate(['slug' => $service['slug']], $service);
        }
    }
}