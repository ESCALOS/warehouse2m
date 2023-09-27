<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class InputContact extends Component
{
    public $model;
    public $label;
    public $autocomplete;

    /**
     * Input para el contacto
     *
     * @return void
     */
    public function __construct(string $model, string $label, string $autocomplete = '')
    {
         $this->model = $model;
         $this->label = $label;
         $this->autocomplete = $autocomplete;
    }

    public function render(): View|Closure|string
    {
        return view('components.input-contact');
    }
}
