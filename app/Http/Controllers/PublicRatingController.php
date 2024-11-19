<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class PublicRatingController extends Controller
{
    public function __construct()
    {
        $this->middleware('server.status');
    }

    public function index() {
        $rating = server_rating();
        return view('pages.main.publicrating', compact('rating'));
    }
}
