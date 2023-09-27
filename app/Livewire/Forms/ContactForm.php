<?php

namespace App\Livewire\Forms;

use App\Mail\ContactMailable;
use Livewire\Attributes\Rule;
use Livewire\Form;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Mail;

class ContactForm extends Form
{
    #[Rule('required', message: 'Ingrese su nombre')]
    public $name = '';
    #[Rule('required', message: 'Ingrese su correo')]
    #[Rule('email:filter', message: 'Correo Inválido')]
    public $email = '';
    #[Rule('required', message: 'Falta su celular')]
    #[Rule('regex:/^\d{3}-\d{3}-\d{3}$/', message: 'Celular inválido')]
    public $phoneNumber = '';
    #[Rule('required', message: 'Ingrese un mensaje')]
    public $content = '';

    public function send(): void {
        $this->validate();
        Mail::to('stornblood6969@gmail.com')->send(new ContactMailable);
        Notification::make()
            ->title('Mensaje enviado')
            ->success()
            ->send();
        $this->reset();
    }
}
