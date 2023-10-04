<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Rule;
use Livewire\Form;

class ContactForm extends Form
{
    #[Rule('required', message: 'Ingrese su nombre')]
    public $name = '';
    #[Rule('required', message: 'Ingrese su correo')]
    #[Rule('email:rfc,dns', message: 'Correo Inválido')]
    public $email = '';
    #[Rule('required', message: 'Falta su celular')]
    #[Rule('regex:/^\d{3}-\d{3}-\d{3}$/', message: 'Celular inválido')]
    public $phoneNumber = '';
    #[Rule('required', message: 'Ingrese un mensaje')]
    public $content = '';

}
