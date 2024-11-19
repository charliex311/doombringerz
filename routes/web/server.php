<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Redirect;


Route::get('setserver/{server_id}', function ($server_id) {

    $referer = Redirect::back()->getTargetUrl();

    //app()->setlocale($locale);
    session()->put('server_id', $server_id);

    return redirect($referer);

})->name('setserver');
