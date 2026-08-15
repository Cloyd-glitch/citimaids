<?php
// Destination: app/Livewire/Welcome/Navigation.php

namespace App\Livewire\Welcome;

use Livewire\Component;

class Navigation extends Component
{
    public function render()
    {
        return view('livewire.welcome.navigation', [
            'links' => [
                ['label' => 'Services', 'href' => url('/services')],
                ['label' => 'How It Works', 'href' => url('/#how-it-works')],
                ['label' => 'Pricing', 'href' => url('/#pricing')],
                ['label' => 'FAQ', 'href' => url('/#faq')],
            ],
        ]);
    }
}