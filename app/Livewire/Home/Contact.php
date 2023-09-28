<?php

namespace App\Livewire\Home;

use App\Mail\ContactMailable;
use App\Livewire\Forms\ContactForm;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Mail;


class Contact extends Component
{
    public ContactForm $form;

    public function send(): void {
        $this->form->validate();

        Mail::to('stornblood6969@gmail.com')->send(new ContactMailable($this->form->all()));
        Notification::make()
            ->title('Mensaje enviado')
            ->success()
            ->send();

        //$this->form->reset();
    }

    #[Layout('layouts.guest')]
    public function render()
    {
        return view('livewire.home.contact');
    }
}
