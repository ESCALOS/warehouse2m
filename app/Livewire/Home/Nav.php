<?php

namespace App\Livewire\Home;

use Livewire\Component;

class Nav extends Component
{
    public $routes = [
        [
            'name' => 'Inicio',
            'route' => 'home.index'
        ],
        [
            'name' => 'Nosotros',
            'route' => 'home.about'
        ],
        [
            'name' => 'Productos',
            'route' => 'home.services'
        ],
        [
            'name' => 'Contactos',
            'route' => 'home.contact'
        ]
    ];
    public function render()
    {
        return view('livewire.home.nav');
    }
}
