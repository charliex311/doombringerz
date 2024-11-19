<?php

namespace App\Http\Controllers;

use App\Models\Release;
use Illuminate\Http\Request;

class RoadmapController extends Controller
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
        $releases = Release::query()->get();

        return view('pages.main.roadmap', compact('releases'));
    }

}
