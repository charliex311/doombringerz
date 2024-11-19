<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Redirect;


Route::get('settheme/{theme}', function ($theme) {

    $url = Redirect::back()->getTargetUrl();
    session()->put('theme', $theme);

    return redirect($url);

})->name('settheme');
