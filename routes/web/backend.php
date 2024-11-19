<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\BackendController;
use App\Http\Controllers\Backend\Auth\BackendLoginController;
use App\Http\Controllers\Backend\SettingsController;
use App\Http\Middleware\Localization;

Route::prefix('admin')->group(function () {

    Route::get('/login', [BackendLoginController::class, 'index']);
    Route::get('/login_2fa', [BackendLoginController::class, 'login_2fa']);
    Route::get('/logout', [BackendLoginController::class, 'logout'])->name('backend.logout');

    Route::post('/login', [BackendLoginController::class, 'authenticate'])->name('backend.login');
    Route::post('/login_2fa', [BackendLoginController::class, 'authenticate_2fa'])->name('backend.login_2fa');

    Route::middleware('server.config')->group(function () {
        Route::middleware('backend')->group(function () {

            Route::get('/', [BackendController::class, 'index'])->name('backend');

            Route::get('/updateitems', [\App\Http\Controllers\Backend\UpdateitemsController::class, 'index']);

            Route::prefix('settings')->group(function () {

                Route::get('/', [\App\Http\Controllers\Backend\SettingsController::class, 'index'])->name('backend.settings');
                Route::get('/site', [\App\Http\Controllers\Backend\SettingsController::class, 'site'])->name('settings.site');
                Route::get('/faq_page', [\App\Http\Controllers\Backend\SettingsController::class, 'faq_page'])->name('settings.faq_page');
                Route::get('/reports', [\App\Http\Controllers\Backend\SettingsController::class, 'reports'])->name('settings.reports');
                Route::get('/project_name', [\App\Http\Controllers\Backend\SettingsController::class, 'project_name'])->name('settings.project_name');
                Route::get('/robots', [\App\Http\Controllers\Backend\SettingsController::class, 'robots'])->name('settings.robots');
                Route::get('/sitemap', [\App\Http\Controllers\Backend\SettingsController::class, 'sitemap'])->name('settings.sitemap');
                Route::get('/langs', [\App\Http\Controllers\Backend\SettingsController::class, 'langs'])->name('settings.langs');
                Route::get('/analitics', [\App\Http\Controllers\Backend\SettingsController::class, 'analitics'])->name('settings.analitics');
                Route::get('/about', [\App\Http\Controllers\Backend\SettingsController::class, 'about'])->name('settings.about');
                Route::get('/about_servers', [\App\Http\Controllers\Backend\SettingsController::class, 'about_servers'])->name('settings.about_servers');
                Route::get('/download', [\App\Http\Controllers\Backend\SettingsController::class, 'download'])->name('settings.download');
                Route::get('/login', [\App\Http\Controllers\Backend\SettingsController::class, 'login'])->name('settings.login');
                Route::get('/login_2fa', [\App\Http\Controllers\Backend\SettingsController::class, 'login_2fa'])->name('settings.login_2fa');
                Route::get('/policy', [\App\Http\Controllers\Backend\SettingsController::class, 'policy'])->name('settings.policy');
                Route::get('/forum', [\App\Http\Controllers\Backend\SettingsController::class, 'forum'])->name('settings.forum');
                Route::get('/social', [\App\Http\Controllers\Backend\SettingsController::class, 'social'])->name('settings.social');
                Route::get('/donat', [\App\Http\Controllers\Backend\SettingsController::class, 'donat'])->name('settings.donat');
                Route::get('/score', [\App\Http\Controllers\Backend\SettingsController::class, 'score'])->name('settings.score');
                Route::get('/auction', [\App\Http\Controllers\Backend\SettingsController::class, 'auction'])->name('settings.auction');
                Route::get('/smtp', [\App\Http\Controllers\Backend\SettingsController::class, 'smtp'])->name('settings.smtp');
                Route::get('/recaptcha', [\App\Http\Controllers\Backend\SettingsController::class, 'recaptcha'])->name('settings.recaptcha');
                Route::get('/sms', [\App\Http\Controllers\Backend\SettingsController::class, 'sms'])->name('settings.sms');
                Route::get('/payments', [\App\Http\Controllers\Backend\SettingsController::class, 'payments'])->name('settings.payments');
                Route::get('/streams', [\App\Http\Controllers\Backend\SettingsController::class, 'streams'])->name('settings.streams');
                Route::get('/referrals', [\App\Http\Controllers\Backend\SettingsController::class, 'referrals'])->name('settings.referrals');
                Route::get('/promocodes', [\App\Http\Controllers\Backend\SettingsController::class, 'promocodes'])->name('settings.promocodes');
                Route::get('/luckywheel', [\App\Http\Controllers\Backend\SettingsController::class, 'luckywheel'])->name('settings.luckywheel');
                Route::get('/market', [\App\Http\Controllers\Backend\SettingsController::class, 'market'])->name('settings.market');
                Route::get('/voting', [\App\Http\Controllers\Backend\SettingsController::class, 'voting'])->name('settings.voting');
                Route::get('/game_sessions', [\App\Http\Controllers\Backend\SettingsController::class, 'game_sessions'])->name('settings.game_sessions');
                Route::get('/game_options', [\App\Http\Controllers\Backend\SettingsController::class, 'game_options'])->name('settings.game_options');
                Route::get('/statistics_game_items', [\App\Http\Controllers\Backend\SettingsController::class, 'statistics_game_items'])->name('settings.statistics_game_items');
                Route::get('/register', [\App\Http\Controllers\Backend\SettingsController::class, 'register'])->name('settings.register');
                Route::get('/discord_api', [\App\Http\Controllers\Backend\SettingsController::class, 'discord_api'])->name('settings.discord_api');
                Route::get('/google_api', [\App\Http\Controllers\Backend\SettingsController::class, 'google_api'])->name('settings.google_api');
                Route::post('/', [\App\Http\Controllers\Backend\SettingsController::class, 'store']);

                //User profile setting
                Route::get('/security', [\App\Http\Controllers\Backend\UserSettingsController::class, 'security'])->name('backend.settings.security');
                Route::patch('/security', [\App\Http\Controllers\Backend\UserSettingsController::class, 'security_store']);
                Route::get('/profile', [\App\Http\Controllers\Backend\UserSettingsController::class, 'profile'])->name('backend.settings.profile');
                Route::patch('/profile', [\App\Http\Controllers\Backend\UserSettingsController::class, 'profile_store']);
                Route::get('/activity', [\App\Http\Controllers\Backend\UserSettingsController::class, 'activity'])->name('backend.settings.activity');
                Route::get('/activity/{id}', [\App\Http\Controllers\Backend\UserSettingsController::class, 'activity_destroy'])->name('backend.settings.activity.destroy');
            });

            Route::prefix('support')->group(function () {
                Route::get('/', [\App\Http\Controllers\TicketController::class, 'support'])->name('tickets.all');
                Route::get('/{ticket}', [\App\Http\Controllers\TicketController::class, 'backend_show'])->name('backend.tickets.show');
                Route::post('/{ticket}/answer', [\App\Http\Controllers\TicketController::class, 'backend_update'])->name('backend.tickets.update');
                Route::post('/{ticket}/isread', [\App\Http\Controllers\TicketController::class, 'backend_isread'])->name('backend.tickets.isread');
                Route::post('/{ticket}/close', [\App\Http\Controllers\TicketController::class, 'backend_close'])->name('backend.tickets.close');
                Route::get('/{ticket}/solve', [\App\Http\Controllers\TicketController::class, 'backend_solve'])->name('backend.tickets.solve');
                Route::post('/{ticket}/update_reply', [\App\Http\Controllers\TicketController::class, 'backend_update_reply'])->name('backend.tickets.reply.update');
                Route::post('/{ticket}/update_question', [\App\Http\Controllers\TicketController::class, 'backend_update_question'])->name('backend.tickets.question.update');
            });

            Route::prefix('reports')->group(function () {
                Route::get('/', [\App\Http\Controllers\ReportController::class, 'support'])->name('reports.all');
                Route::get('/{report}', [\App\Http\Controllers\ReportController::class, 'backend_show'])->name('backend.reports.show');
                Route::get('/{report}/edit', [\App\Http\Controllers\ReportController::class, 'backend_edit'])->name('backend.reports.edit');
                Route::post('/{report}/answer', [\App\Http\Controllers\ReportController::class, 'backend_answer'])->name('backend.reports.answer');
                Route::post('/{report}/update_reply', [\App\Http\Controllers\ReportController::class, 'backend_update_reply'])->name('backend.reports.reply.update');
                Route::post('/{report}/update', [\App\Http\Controllers\ReportController::class, 'backend_update'])->name('backend.reports.update');
                Route::get('/{report}/lock', [\App\Http\Controllers\ReportController::class, 'lock'])->name('backend.reports.lock');
                Route::get('/{report}/unlock', [\App\Http\Controllers\ReportController::class, 'unlock'])->name('backend.reports.unlock');
                Route::post('/change_status', [\App\Http\Controllers\ReportController::class, 'change_status'])->name('backend.reports.status.change');
            });

            Route::prefix('logs')->group(function () {
                Route::get('/', [\App\Http\Controllers\LogController::class, 'index'])->name('logs.all');
                Route::get('/payments', [\App\Http\Controllers\Backend\LogController::class, 'payments'])->name('logs.payments');
                Route::get('/visits', [\App\Http\Controllers\Backend\LogController::class, 'visits'])->name('logs.visits');
                Route::get('/registrations', [\App\Http\Controllers\Backend\LogController::class, 'registrations'])->name('logs.registrations');
                Route::get('/gamecurrencylogs', [\App\Http\Controllers\Backend\LogController::class, 'gamecurrencylogs'])->name('logs.gamecurrencylogs');
                Route::get('/adminlogs', [\App\Http\Controllers\Backend\LogController::class, 'adminlogs'])->name('logs.adminlogs');
                Route::get('/servererrors', [\App\Http\Controllers\Backend\LogController::class, 'servererrors'])->name('logs.servererrors');
                Route::get('/statistics_game_items', [\App\Http\Controllers\Backend\LogController::class, 'statistics_game_items'])->name('logs.statistics_game_items');
                Route::get('/userlogs/{user}', [\App\Http\Controllers\Backend\LogController::class, 'userlogs'])->name('logs.userlogs');
                Route::get('/activitylogs', [\App\Http\Controllers\Backend\LogController::class, 'activitylogs'])->name('logs.activitylogs');
            });

            Route::prefix('users')->group(function () {
                Route::get('/', [\App\Http\Controllers\UserController::class, 'index'])->name('users');
                Route::get('/admin/{user}', [\App\Http\Controllers\UserController::class, 'admin'])->name('user.role.admin');
                Route::get('/support/{user}', [\App\Http\Controllers\UserController::class, 'support'])->name('user.role.support');
                Route::get('/user/{user}', [\App\Http\Controllers\UserController::class, 'user'])->name('user.role.user');
                Route::get('/investor/{user}', [\App\Http\Controllers\UserController::class, 'investor'])->name('user.role.investor');
                Route::get('/ban/{user}', [\App\Http\Controllers\UserController::class, 'ban'])->name('user.ban');
                Route::get('/unban/{user}', [\App\Http\Controllers\UserController::class, 'unban'])->name('user.unban');
                Route::post('/setbalance', [\App\Http\Controllers\UserController::class, 'setBalance'])->name('user.balance.set');
                Route::post('/setitem', [\App\Http\Controllers\UserController::class, 'setItem'])->name('user.item.set');
                Route::get('/details/{user}', [\App\Http\Controllers\UserController::class, 'details'])->name('backend.user.details');
                Route::post('/password/change', [\App\Http\Controllers\UserController::class, 'backend_change_password'])->name('backend.user.change.password');
                Route::post('/email/change', [\App\Http\Controllers\UserController::class, 'backend_change_email'])->name('backend.user.change.email');
                Route::get('/account/create/{user}', [\App\Http\Controllers\UserController::class, 'backend_account_create'])->name('backend.user.account.create');
                Route::post('/account/password/change', [\App\Http\Controllers\AccountController::class, 'backend_change_password'])->name('backend.user.account.change.password');
                Route::post('/account/transfer', [\App\Http\Controllers\AccountController::class, 'transfer_account'])->name('backend.user.account.transfer');
                Route::post('/getUserByName', [\App\Http\Controllers\UserController::class, 'getUserByName'])->name('backend.users.getuserbyname');
                Route::get('/warehouse/{user}', [\App\Http\Controllers\UserController::class, 'warehouse'])->name('backend.user.warehouse');
                Route::post('/warehouse/update', [\App\Http\Controllers\UserController::class, 'warehouse_update'])->name('backend.user.warehouse.update');
                Route::post('/warehouse/delete', [\App\Http\Controllers\UserController::class, 'warehouse_delete'])->name('backend.user.warehouse.delete');
            });

            Route::post('/shopitems/getProductByName', [\App\Http\Controllers\Backend\ShopItemController::class, 'getProductByName'])->name('backend.shopitems.getProductByName');

            Route::get('/bonusitems', [\App\Http\Controllers\Backend\BonusitemsController::class, 'index'])->name('backend.bonusitems');
            Route::post('/bonusitems', [\App\Http\Controllers\Backend\BonusitemsController::class, 'store'])->name('backend.bonusitems.set');

            Route::get('/promocodes/generate', [\App\Http\Controllers\Backend\PromoCodeController::class, 'generate'])->name('promocodes.generate');
            Route::post('/promocodes/generate', [\App\Http\Controllers\Backend\PromoCodeController::class, 'generate_store'])->name('promocodes.generate_store');

            //Resource routes
            Route::resource('articles', \App\Http\Controllers\Backend\ArticleController::class)->except('show');
            Route::resource('faqs', \App\Http\Controllers\Backend\FaqController::class)->except('show');
            Route::resource('videos', \App\Http\Controllers\Backend\VideoController::class)->except('show');
            Route::resource('streams', \App\Http\Controllers\Backend\StreamController::class)->except('show');
            Route::resource('servers', \App\Http\Controllers\Backend\ServerController::class)->except('show');
            Route::resource('referrals', \App\Http\Controllers\Backend\ReferralController::class);
            Route::resource('features', \App\Http\Controllers\Backend\FeatureController::class)->except('show');
            Route::resource('releases', \App\Http\Controllers\Backend\ReleaseController::class)->except('show');
            Route::resource('releasenotes', \App\Http\Controllers\Backend\ReleaseNoteController::class)->except('show');
            Route::resource('shopitems', \App\Http\Controllers\Backend\ShopItemController::class)->except('show');
            Route::resource('shopcoupons', \App\Http\Controllers\Backend\ShopCouponController::class)->except('show');
            Route::resource('shopcategories', \App\Http\Controllers\Backend\ShopCategoryController::class)->except('show');
            Route::resource('marketitems', \App\Http\Controllers\Backend\MarketItemController::class)->except('show');
            Route::resource('marketcategories', \App\Http\Controllers\Backend\MarketCategoryController::class)->except('show');
            Route::resource('bazaaritems', \App\Http\Controllers\Backend\BazaarItemController::class)->except('show');
            Route::resource('bazaarcategories', \App\Http\Controllers\Backend\BazaarCategoryController::class)->except('show');
            Route::resource('promocodes', \App\Http\Controllers\Backend\PromoCodeController::class)->except('show');

            Route::get('/servers/{id}/settings', [\App\Http\Controllers\Backend\ServerController::class, 'settings'])->name('server.settings');
        });

    });
});
