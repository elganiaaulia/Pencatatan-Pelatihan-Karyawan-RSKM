<?php

namespace App\View\Components\Layouts;

use App\Models\Periode;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Sidebar extends Component
{
    public $periode;
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->periode = Periode::where('status', 1)->get();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.layouts.sidebar');
    }
}
