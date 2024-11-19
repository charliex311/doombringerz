<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class RatingController extends Controller
{
    public function __construct()
    {
        $this->middleware('server.status');
    }

    public function index() {
        $rating = server_rating();

        return view('pages.cabinet.rating', compact('rating'));
    }
}
