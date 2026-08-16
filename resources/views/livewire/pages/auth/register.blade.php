<?php
// Destination: resources/views/livewire/pages/auth/register.blade.php

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('components.layouts.guest')] class extends Component
{
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    public function register(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'string', 'confirmed', Password::defaults()],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        event(new Registered($user = User::create($validated)));

        Auth::login($user);

        $this->redirect(route('dashboard', absolute: false), navigate: true);
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
            Create your account
        </h1>
        <p class="mt-1 text-sm text-slate-500">Book your first clean in a couple of minutes.</p>
    </div>

    <form wire:submit="register" class="mt-8 space-y-5">
        <div>
            <label for="name" class="text-xs font-semibold uppercase tracking-wide text-slate-500">Full name</label>
            <input wire:model="name" id="name" type="text" required autofocus autocomplete="name"
                   class="mt-2 w-full rounded-lg border border-slate-200 px-4 py-3 text-sm text-slate-700 focus:border-[#123C69] focus:outline-none focus:ring-1 focus:ring-[#123C69]">
            @error('name') <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="email" class="text-xs font-semibold uppercase tracking-wide text-slate-500">Email</label>
            <input wire:model="email" id="email" type="email" required autocomplete="username"
                   class="mt-2 w-full rounded-lg border border-slate-200 px-4 py-3 text-sm text-slate-700 focus:border-[#123C69] focus:outline-none focus:ring-1 focus:ring-[#123C69]">
            @error('email') <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="password" class="text-xs font-semibold uppercase tracking-wide text-slate-500">Password</label>
            <input wire:model="password" id="password" type="password" required autocomplete="new-password"
                   class="mt-2 w-full rounded-lg border border-slate-200 px-4 py-3 text-sm text-slate-700 focus:border-[#123C69] focus:outline-none focus:ring-1 focus:ring-[#123C69]">
            @error('password') <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="password_confirmation" class="text-xs font-semibold uppercase tracking-wide text-slate-500">Confirm password</label>
            <input wire:model="password_confirmation" id="password_confirmation" type="password" required autocomplete="new-password"
                   class="mt-2 w-full rounded-lg border border-slate-200 px-4 py-3 text-sm text-slate-700 focus:border-[#123C69] focus:outline-none focus:ring-1 focus:ring-[#123C69]">
            @error('password_confirmation') <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p> @enderror
        </div>

        <button type="submit" wire:loading.attr="disabled" wire:target="register"
                class="w-full rounded-lg bg-[#F6AD37] py-3 text-sm font-semibold text-[#123C69] shadow-sm transition hover:bg-[#f5a01c] disabled:opacity-60">
            <span wire:loading.remove wire:target="register">Create account</span>
            <span wire:loading wire:target="register">Creating account…</span>
        </button>
    </form>

    <p class="mt-6 text-center text-sm text-slate-500">
        Already have an account?
        <a href="{{ route('login') }}" wire:navigate class="font-semibold text-[#123C69] hover:underline">Log in</a>
    </p>
</div>