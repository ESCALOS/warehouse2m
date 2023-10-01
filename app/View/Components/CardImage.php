<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class CardImage extends Component
{
    public $image, $title;

    public function __construct(string $image, string $title = '')
    {
        $this->image = $image;
        $this->title = $title;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.card-image');
    }
}
