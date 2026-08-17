@extends('components.layouts.admin')

@section('content')
<div class="p-6">
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-2xl font-bold text-gray-800">Dashboard</h2>
        <p class="text-gray-600 mt-2">You're logged in!</p>

        <!-- Dashboard Stats -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mt-6">
            <div class="bg-blue-50 p-4 rounded-lg border border-blue-100">
                <h3 class="font-semibold text-blue-600">Today's Bookings</h3>
                <p class="text-2xl font-bold">0</p>
            </div>
            <div class="bg-green-50 p-4 rounded-lg border border-green-100">
                <h3 class="font-semibold text-green-600">Revenue</h3>
                <p class="text-2xl font-bold">AED 0</p>
            </div>
            <div class="bg-yellow-50 p-4 rounded-lg border border-yellow-100">
                <h3 class="font-semibold text-yellow-600">Pending</h3>
                <p class="text-2xl font-bold">0</p>
            </div>
            <div class="bg-red-50 p-4 rounded-lg border border-red-100">
                <h3 class="font-semibold text-red-600">Cancellations</h3>
                <p class="text-2xl font-bold">0</p>
            </div>
        </div>
    </div>
</div>
@endsection