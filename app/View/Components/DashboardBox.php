<?php

namespace App\View\Components;

use Illuminate\View\Component;

class DashboardBox extends Component
{
    public $title;
    public $value;

    public function __construct($title, $value)
    {
        $this->title = $title;
        $this->value = $value;
    }

    public function render()
    {
        return view('components.dashboard-box');
    }
}
