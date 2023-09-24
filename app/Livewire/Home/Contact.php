<?php

namespace App\Livewire\Home;

use Livewire\Attributes\Layout;
use Livewire\Component;

class Contact extends Component
{
    #[Layout('layouts.guest')]
    public function render()
    {
        return view('livewire.home.contact');
    }
}
