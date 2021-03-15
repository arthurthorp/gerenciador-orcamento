<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ResponsiveNavLink extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */

    public $active;
    public function __construct($active)
    {
        $this->active = $active;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.responsive-nav-link');
    }
}