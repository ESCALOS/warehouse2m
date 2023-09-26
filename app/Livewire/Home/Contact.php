<?php

namespace App\Livewire\Home;

use Livewire\Attributes\Layout;
use Livewire\Component;
use Filament\Notifications\Notification;

class Contact extends Component
{
    public $name = '';
    public $email = '';
    public $phoneNumber = '';
    public $message = '';

    public function send(): void {
        Notification::make()
            ->title('Mensaje Enviado')
            ->success()
            ->color('danger')
            ->iconColor('warning')
            ->send();
    }

    #[Layout('layouts.guest')]
    public function render()
    {
        return view('livewire.home.contact');
    }
}
