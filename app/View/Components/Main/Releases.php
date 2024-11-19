<?php

namespace App\View\Components\Main;

use App\Models\Release;
use Illuminate\View\Component;

class Releases extends Component
{
    public $releases;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        $releases = Release::latest()->limit(10)->get();
        $this->releases = $releases->sortBy('sort');
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.main.releases');
    }
}
