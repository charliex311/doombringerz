<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\EmailVerifyController;
use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\Localization;


Route::group(['prefix' => Localization::getLocale()], function() {

    Route::middleware('visit.statistics')->group(function () {
        Route::get('/', function () { return view('pages.main.home'); })->name('index');

        Route::get('/about', function () { return view('pages.main.about_us'); })->name('about_us');
        Route::get('/about_servers', function () { return view('pages.main.about_servers'); })->name('about_servers');

        Route::get('/terms', function () { return view('pages.main.terms'); })->name('terms');
        Route::get('/privacy', function () { return view('pages.main.privacy'); })->name('privacy');
        Route::get('/rules', function () { return view('pages.main.rules'); })->name('rules');
        Route::get('/refund', function () { return view('pages.main.refund'); })->name('refund');
        Route::get('/agreement', function () { return view('pages.main.agreement'); })->name('agreement');

        Route::get('/news', [\App\Http\Controllers\ArticleController::class, 'index'])->name('news');
        Route::get('/news/more', [\App\Http\Controllers\ArticleController::class, 'more'])->name('news.more');
        Route::get('/news/{article}', [\App\Http\Controllers\ArticleController::class, 'show'])->name('news.show');

        Route::get('/roadmap', [\App\Http\Controllers\RoadmapController::class, 'index'])->name('roadmap');
        Route::get('/faq', [\App\Http\Controllers\FaqController::class, 'index'])->name('faq');

        Route::get('/login', [LoginController::class, 'index']);
        Route::post('/login_discord', [LoginController::class, 'loginDiscord'])->name('loginDiscord');
        Route::get('/auth/discord', [LoginController::class, 'authenticateDiscord'])->name('authenticateDiscord');
        Route::post('/login_google', [LoginController::class, 'loginGoogle'])->name('loginGoogle');
        Route::get('/auth/google', [LoginController::class, 'authenticateGoogle'])->name('authenticateGoogle');
        Route::get('/login_2fa', [LoginController::class, 'login_2fa'])->name('user.login_2fa');
        Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
        Route::get('/register', [RegisterController::class, 'index']);

        Route::middleware('server.config')->group(function () {
            Route::get('/donation', [\App\Http\Controllers\DonationController::class, 'index'])->name('donation');
            Route::post('/donation', [\App\Http\Controllers\DonationController::class, 'create']);
            Route::post('donation/transfer', [\App\Http\Controllers\DonationController::class, 'transfer_store']);

            Route::get('/ratings', [\App\Http\Controllers\RatingsController::class, 'index'])->name('ratings');
        });
    });

    Route::get('/email/verify/{token}', [EmailVerifyController::class, 'verify'])->name('verification.verify');

    Route::post('/login', [LoginController::class, 'authenticate'])->name('login');
    Route::post('/login_2fa', [LoginController::class, 'authenticate_2fa'])->name('user.login_2fa.auth');
    Route::post('/register', [RegisterController::class, 'register'])->name('register');

    Auth::routes(['register' => false, 'login' => false, 'logout' => false, 'verify' => false]);
});

Route::post('/register/sendcode', [RegisterController::class, 'sendcode'])->name('register.sendcode');
Route::post('/password/sms', [ResetPasswordController::class, 'sms'])->name('password.sms');
Route::get('/download', [\App\Http\Controllers\DownloadController::class, 'registrationData'])->name('download.registrationData');

Route::get('/ref/{ref}', [\App\Http\Controllers\ReferralController::class, 'setRefSession'])->name('referrals.set');

Route::get('track', function () {
    return view('pages.main.track');
})->name("track");

Route::get('contact', function () {
    return view('pages.main.contact');
})->name("contact");

Route::get('digi-goods', function () {
    return view('pages.main.digi-goods');
})->name("digi-goods");

Route::get('merchandise', function () {
    return view('pages.main.merchandise');
})->name("merchandise");
