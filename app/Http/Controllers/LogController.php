<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class LogController extends Controller
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

    /**
     * Index page with form update settings
     */
    public function index(Request $request)
    {
        $logs = ActivityLog::where('user_id', auth()->user()->id)->where('is_admin', 0);

        if (request()->has('log_type') && request()->input('log_type') >= 0) {
            $logs->where('type', request()->input('log_type'));
        }
        $logs = $logs->latest()->paginate();

        return view('pages.cabinet.user.activitylogs', compact('logs'));
    }
}
