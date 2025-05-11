<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class AppLayout extends Component
{
    /**
     * Get the view / contents that represents the component.
     */
    public function render(): View
    {

        // views/layouts/app.blade.php  (x-app-layout)
        return view('layouts.app');
    }
}
