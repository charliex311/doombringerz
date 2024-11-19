<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;

Route::get('setlocale/{locale}', function ($locale) {

    $referer = Redirect::back()->getTargetUrl();
    $parse_url = parse_url($referer, PHP_URL_PATH);

    $segments = explode('/', $parse_url);

    if (in_array($segments[1], App\Http\Middleware\Localization::$languages)) {
        unset($segments[1]);
    }

    if ($locale != App\Http\Middleware\Localization::$mainLanguage){
        array_splice($segments, 1, 0, $locale);
    }

    $url = Request::root().implode("/", $segments);

    if(parse_url($referer, PHP_URL_QUERY)){
        $url = $url.'?'. parse_url($referer, PHP_URL_QUERY);
    }

    //Фикс, потому что на главной дописывает в адрес сайта public/
    if (mb_substr($url, -1) == "/") {
        $url = substr($url,0,-1);
    }

    app()->setlocale($locale);
    session()->put('locale', $locale);

    return redirect($url);

})->name('setlocale');
