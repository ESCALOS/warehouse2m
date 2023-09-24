<?php

namespace App\Livewire\Home;

use Livewire\Attributes\Layout;
use Livewire\Component;

class Services extends Component
{
    #[Layout('layouts.guest')]
    public function render()
    {
        return view('livewire.home.services');
    }
}
