<?php

namespace App\Livewire\Customer;

use App\Models\Booking;
use App\Models\Customer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Livewire\Component;

class BookingWizard extends Component
{
    // ----- Wizard state -----
    public int $step = 1;
    public int $maxStepReached = 1;

    // ----- Step 1: Property & Service -----
    public string $propertyType = 'apartment'; // apartment | villa | office
    public int $rooms = 2;
    public int $bathrooms = 1;
    public bool $deepClean = false;
    public string $frequency = 'onetime'; // onetime | weekly | biweekly | monthly

    // ----- Step 2: Schedule -----
    public ?string $date = null;
    public ?string $time = null;

    // ----- Step 3: Your Details -----
    public string $name = '';
    public string $email = '';
    public string $phone = '';
    public string $address = '';
    public ?string $notes = null;

    // ----- Step 4: Review & Confirm -----
    public bool $agreeTerms = false;

    // ----- Result -----
    public bool $submitted = false;
    public ?string $bookingReference = null;

    /**
     * Prefill from the quote calculator's "Continue to Booking" link:
     * /book?type=villa&rooms=3&bathrooms=2&deep=1&frequency=weekly&total=210
     */
    public function mount(): void
    {
        $this->propertyType = request()->query('type', $this->propertyType);
        $this->rooms = (int) request()->query('rooms', $this->rooms) ?: $this->rooms;
        $this->bathrooms = (int) request()->query('bathrooms', $this->bathrooms) ?: $this->bathrooms;
        $this->deepClean = request()->query('deep') === '1';
        $this->frequency = request()->query('frequency', $this->frequency);

        if (Auth::check()) {
            $this->name = Auth::user()->name;
            $this->email = Auth::user()->email;
        }
    }

    protected function rates(): array
    {
        return ['apartment' => 35, 'villa' => 45, 'office' => 40];
    }

    protected function frequencyDiscount(): array
    {
        return ['onetime' => 0, 'weekly' => 0.20, 'biweekly' => 0.15, 'monthly' => 0.10];
    }

    public function estimatedHours(): float
    {
        return max(2, $this->rooms * 0.75 + $this->bathrooms * 0.4 + ($this->deepClean ? 1.5 : 0));
    }

    public function estimatedTotal(): float
    {
        $base = $this->estimatedHours() * ($this->rates()[$this->propertyType] ?? 35);
        $discount = $base * ($this->frequencyDiscount()[$this->frequency] ?? 0);

        return round($base - $discount);
    }

    public function incrementRooms(): void
    {
        $this->rooms = min(10, $this->rooms + 1);
    }

    public function decrementRooms(): void
    {
        $this->rooms = max(1, $this->rooms - 1);
    }

    public function incrementBathrooms(): void
    {
        $this->bathrooms = min(6, $this->bathrooms + 1);
    }

    public function decrementBathrooms(): void
    {
        $this->bathrooms = max(1, $this->bathrooms - 1);
    }

    public function toggleDeepClean(): void
    {
        $this->deepClean = ! $this->deepClean;
    }

    public function goToStep(int $step): void
    {
        // Only allow jumping back into steps already completed.
        if ($step <= $this->maxStepReached) {
            $this->step = $step;
        }
    }

    public function nextStep(): void
    {
        if ($this->step === 2) {
            $this->validate([
                'date' => 'required|date|after_or_equal:today',
                'time' => 'required|string',
            ]);
        }

        $this->step = min(4, $this->step + 1);
        $this->maxStepReached = max($this->maxStepReached, $this->step);
    }

    public function previousStep(): void
    {
        $this->step = max(1, $this->step - 1);
    }

    public function submit(): void
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string|max:30',
            'address' => 'required|string|max:500',
            'agreeTerms' => 'accepted',
        ]);

        // Match an existing customer by email (so repeat bookings link to the
        // same customer record), otherwise create a new one. If the person is
        // logged in, tie the customer record to their account.
        $customer = Customer::updateOrCreate(
            ['email' => $this->email],
            [
                'user_id' => Auth::id(),
                'name' => $this->name,
                'phone' => $this->phone,
                'address' => $this->address,
            ]
        );

        $booking = Booking::create([
            'customer_id' => $customer->id,
            'property_type' => $this->propertyType,
            'rooms' => $this->rooms,
            'bathrooms' => $this->bathrooms,
            'deep_clean' => $this->deepClean,
            'frequency' => $this->frequency,
            'scheduled_date' => $this->date,
            'scheduled_time' => $this->time,
            'address' => $this->address,
            'notes' => $this->notes,
            'total' => $this->estimatedTotal(),
            'status' => 'pending',
            'reference' => 'CM-'.strtoupper(Str::random(6)),
        ]);

        $this->bookingReference = $booking->reference;
        $this->submitted = true;
    }

    public function render()
    {
        return view('livewire.customer.booking-wizard');
    }
}