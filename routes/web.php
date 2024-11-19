<?php

use App\Http\Controllers\Auth\EmailVerifyController;
use App\Models\Session;
use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\DownloadController;

use App\Http\Middleware\Localization;

use App\Http\Controllers\Backend\BackendController;
use App\Http\Controllers\Backend\Auth\BackendLoginController;

use Illuminate\Support\Facades\Auth;

require __DIR__.'/web/main.php';
require __DIR__.'/web/account.php';
require __DIR__.'/web/backend.php';

//Returns from payments
require __DIR__.'/web/payments.php';

//Switching languages
require __DIR__.'/web/locale.php';

//Switching servers
require __DIR__.'/web/server.php';

//Switching theme
require __DIR__.'/web/theme.php';
