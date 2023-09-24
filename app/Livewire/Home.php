<?php

namespace App\Livewire;

use Livewire\Attributes\Layout;
use Livewire\Component;

class Home extends Component
{
    #[Layout('layouts.guest')]
    public function render()
    {
        return view('livewire.home');
    }
}
