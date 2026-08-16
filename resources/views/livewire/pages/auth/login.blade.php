<?php
// Destination: resources/views/livewire/pages/auth/login.blade.php

use App\Models\User;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('components.layouts.guest')] class extends Component
{
    public string $email = '';
    public string $password = '';
    public bool $remember = false;

    public function login(): void
    {
        $this->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);

        $this->ensureIsNotRateLimited();

        if (! Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'email' => __('auth.failed'),
            ]);
        }

        RateLimiter::clear($this->throttleKey());
        request()->session()->regenerate();

        $this->redirect(route('dashboard', absolute: false), navigate: true);
    }

    protected function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout(request()));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => __('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    protected function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->email).'|'.request()->ip());
    }
}; ?>

<div>
    <div class="text-center">
        <a href="{{ url('/') }}" wire:navigate class="inline-flex items-center gap-2">
            <span class="flex h-10 w-10 items-center justify-center rounded-lg bg-[#123C69]">
                <x-heroicon-s-sparkles class="h-5 w-5 text-[#4FD1C5]" />
            </span>
            <span class="text-xl font-bold tracking-tight text-[#123C69]">Citi<span class="text-[#4FD1C5]">Maids</span></span>
        </a>
        <h1 class="mt-6 font-['Plus_Jakarta_Sans'] text-2xl font-extrabold text-slate-900" style="font-family:'Plus Jakarta Sans',sans-serif;">
            Welcome back
        </h1>
        <p class="mt-1 text-sm text-slate-500">Log in to manage your bookings.</p>
    </div>

    @session('status')
        <div class="mt-6 rounded-lg bg-[#4FD1C5]/10 px-4 py-3 text-sm font-medium text-[#0f9488]">
            {{ session('status') }}
        </div>
    @endsession

    <form wire:submit="login" class="mt-8 space-y-5">
        <div>
            <label for="email" class="text-xs font-semibold uppercase tracking-wide text-slate-500">Email</label>
            <input wire:model="email" id="email" type="email" required autofocus autocomplete="username"
                   class="mt-2 w-full rounded-lg border border-slate-200 px-4 py-3 text-sm text-slate-700 focus:border-[#123C69] focus:outline-none focus:ring-1 focus:ring-[#123C69]">
            @error('email') <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p> @enderror
        </div>

        <div>
            <div class="flex items-center justify-between">
                <label for="password" class="text-xs font-semibold uppercase tracking-wide text-slate-500">Password</label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" wire:navigate class="text-xs font-medium text-[#123C69] hover:underline">Forgot password?</a>
                @endif
            </div>
            <input wire:model="password" id="password" type="password" required autocomplete="current-password"
                   class="mt-2 w-full rounded-lg border border-slate-200 px-4 py-3 text-sm text-slate-700 focus:border-[#123C69] focus:outline-none focus:ring-1 focus:ring-[#123C69]">
            @error('password') <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p> @enderror
        </div>

        <label class="flex items-center gap-2">
            <input wire:model="remember" type="checkbox" class="h-4 w-4 rounded border-slate-300 text-[#123C69] focus:ring-[#123C69]">
            <span class="text-sm text-slate-600">Remember me</span>
        </label>

        <button type="submit" wire:loading.attr="disabled" wire:target="login"
                class="w-full rounded-lg bg-[#123C69] py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-[#0d2c4e] disabled:opacity-60">
            <span wire:loading.remove wire:target="login">Log in</span>
            <span wire:loading wire:target="login">Logging in…</span>
        </button>
    </form>

    <p class="mt-6 text-center text-sm text-slate-500">
        Don't have an account?
        <a href="{{ route('register') }}" wire:navigate class="font-semibold text-[#123C69] hover:underline">Sign up</a>
    </p>
</div>