<?php

namespace App\Livewire\Home;

use Livewire\Attributes\Layout;
use Livewire\Component;

class Contact extends Component
{
    public $name = '';
    public $email = '';
    public $phoneNumber = '';
    public $message = '';

    public function send() {
        $this->name = $this->phoneNumber;
    }

    #[Layout('layouts.guest')]
    public function render()
    {
        return view('livewire.home.contact');
    }
}
