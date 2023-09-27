<?php

namespace App\Livewire\Home;

use App\Livewire\Forms\ContactForm;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Contact extends Component
{
    public ContactForm $form;

    public function send() {
        $this->form->send();
    }

    #[Layout('layouts.guest')]
    public function render()
    {
        return view('livewire.home.contact');
    }
}
