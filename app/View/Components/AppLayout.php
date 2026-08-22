<?php

namespace App\View\Components;

use Illuminate\View\Component;

class AppLayout extends Component
{
    public bool $fullscreen;

    public function __construct($fullscreen = false)
    {
        $this->fullscreen = $fullscreen;
    }

    public function render()
    {
        return view('layouts.app');
    }
}