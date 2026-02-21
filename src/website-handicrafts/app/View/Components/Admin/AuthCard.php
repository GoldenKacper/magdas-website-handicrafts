<?php

namespace App\View\Components\Admin;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class AuthCard extends Component
{
    /**
     * The title of the card (optional).
     */
    public ?string $title;


    /**
     * Whether to show the card.
     */
    public bool $show;

    /**
     * The CSS class of the card (optional).
     */
    public ?string $class;

    /**
     * Create a new component instance.
     */
    public function __construct(?string $title = null, bool $show = true, ?string $class = null)
    {
        $this->title = $title;
        $this->show  = $show;
        $this->class = $class;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.admin.auth-card');
    }
}
