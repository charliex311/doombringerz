<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ChangelogController extends Controller
{
    public function __construct()
    {
        $this->middleware('server.status');
    }

    public function index(Request $request) {

        $changelog = '';
        return view('pages.cabinet.changelog', compact('changelog'));
    }

}
