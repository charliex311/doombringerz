<?php

namespace App\Http\Controllers;

use App\Models\Constep;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ConstepController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function index()
    {
        $consteps = Constep::latest()->paginate();
        $consteps = $consteps->sortBy('sort');

        return view('pages.main.connect', compact('consteps'));
    }

}
