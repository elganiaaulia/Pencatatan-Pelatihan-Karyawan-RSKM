<?php

namespace App\View\Components\Layouts;

use App\Models\misc;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Footer extends Component
{
    public $address, $phone;
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $temp = misc::where('misc_type', 'footer')->get();
        $this->address = $temp[0]->misc_detail;
        $this->phone = $temp[1]->misc_detail;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.layouts.footer');
    }
}
