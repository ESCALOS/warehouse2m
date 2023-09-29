<?php

namespace App\Livewire\Home;

use Livewire\Attributes\Layout;
use Livewire\Component;

class Services extends Component
{
    public $grapeImages = ['1sP8xX0xy_gvFu1-dP9OSk-NEbyYLrmNJ','1WwD61ag6-RxufNcgxp-HLSxGJQ2ato43'];
    public $avocadoImages = ['17Be_F8evqYAghKaMkSL0XMtOWiTFXdBN','1fF0P0OsfAP45UnNlOhet-3pbzK4LzChA'];

    #[Layout('layouts.guest')]
    public function render()
    {
        return view('livewire.home.services');
    }
}
