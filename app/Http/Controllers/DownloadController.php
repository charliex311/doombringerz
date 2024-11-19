<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Session;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DownloadController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    public function registrationData()
    {
        $file = Storage::disk('local')->download(session()->get('reg_txt_url', ''), 'register-data.txt', ['Content-Type' => 'application/octet-stream']);

        usleep(1000000);
        session()->forget('reg_txt_url');
        session()->forget('down_reg');

        return $file;
    }

}
