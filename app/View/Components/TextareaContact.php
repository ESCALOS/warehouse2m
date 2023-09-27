<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class TextareaContact extends Component
{
    public $model;
    public $label;

    public function __construct(string $model, string $label)
    {
        $this->model = $model;
        $this->label = $label;
    }


    public function render(): View|Closure|string
    {
        return view('components.textarea-contact');
    }
}
