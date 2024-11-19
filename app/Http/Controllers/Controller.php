<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Session;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function alert($type, $message) {
        $session = Session::get('alert.' . $type);
        $messages = array();
        if ($session) {
            $messages = $session;
        }
        array_push($messages, $message);
        Session::flash('alert.' . $type, $messages);
    }

    protected function activityLog($type, $message) {
        $id = isset(auth()->user()->id) ? auth()->user()->id : 0;
        $name = isset(auth()->user()->name) ? auth()->user()->name : '';
        $email = isset(auth()->user()->email) ? auth()->user()->email : '';
        ActivityLog::create(['user_id' => $id,'ip' => request()->ip(), 'type' => $type, 'is_admin' => 1, 'message' => 'Robot: Player ' . $name . ' (' . $email . ') ' . $message]);
        ActivityLog::create(['user_id' => $id, 'ip' => request()->ip(), 'type' => $type, 'is_admin' => 0, 'message' => 'You ' . $message]);
    }
}
