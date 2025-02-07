<?php

namespace App\View\Components\Main;

use App\Models\Feature;
use Illuminate\View\Component;

class Features extends Component
{
    public $features;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->features = Feature::latest()->limit(10)->get();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.main.features');
    }
}
