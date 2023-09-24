<?php

namespace App\Http\Controllers;

class HomeController extends Controller
{
    private $menu = [
        'Inicio',
        'Nosotros',
        'Servicios',
        'Contactenos'
    ];

    public function __invoke()
    {
        return view('home', [
            'menu' => $this->menu
        ]);
    }
}
