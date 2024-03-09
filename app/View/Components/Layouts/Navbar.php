<?php

namespace App\View\Components\Layouts;

use App\Models\UnitMerk;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Navbar extends Component
{
    public $merks;
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->merks = UnitMerk::all();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.layouts.navbar');
    }
}
