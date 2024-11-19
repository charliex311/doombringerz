<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\EmailVerifyController;
use App\Http\Middleware\Localization;

Route::group(['prefix' => Localization::getLocale()], function() {

    Route::middleware('auth')->group(function () {
        Route::middleware('server.config')->group(function () {
            Route::middleware('visit.statistics')->group(function () {

                Route::prefix('bugs')->group(function () {
                    Route::post('/', [\App\Http\Controllers\ReportController::class, 'store'])->name('reports.store');
                    Route::get('/create', [\App\Http\Controllers\ReportController::class, 'create'])->name('reports.create');
                    Route::post('/{report}/like', [\App\Http\Controllers\ReportController::class, 'like'])->name('reports.like');
                    Route::post('/{report}/replicate', [\App\Http\Controllers\ReportController::class, 'replicate'])->name('reports.replicate');
                    Route::get('/{report}/edit', [\App\Http\Controllers\ReportController::class, 'edit'])->name('reports.edit');
                    Route::post('/{report}/update', [\App\Http\Controllers\ReportController::class, 'update'])->name('reports.update');
                    Route::post('/{report}/reply', [\App\Http\Controllers\ReportController::class, 'reply'])->name('reports.reply');
                    Route::post('/{report}/update_reply', [\App\Http\Controllers\ReportController::class, 'update_reply'])->name('reports.update_reply');
                    Route::get('/{report}/delete', [\App\Http\Controllers\ReportController::class, 'destroy'])->name('reports.delete');
                    Route::post('/{report}/answer', [\App\Http\Controllers\ReportController::class, 'update'])->name('reports.update');
                    Route::get('/{report}', [\App\Http\Controllers\ReportController::class, 'show'])->name('reports.show');

                    Route::get('/{report}/lock', [\App\Http\Controllers\ReportController::class, 'lock'])->name('reports.lock');
                    Route::get('/{report}/unlock', [\App\Http\Controllers\ReportController::class, 'unlock'])->name('reports.unlock');
                    Route::post('/change_status', [\App\Http\Controllers\ReportController::class, 'change_status'])->name('reports.status.change');
                });

                Route::prefix('account')->group(function () {

                    Route::get('/', [\App\Http\Controllers\AccountController::class, 'index'])->name('cabinet');
                    Route::post('/create', [\App\Http\Controllers\AccountController::class, 'store'])->name('account.store');
                    Route::post('/password', [\App\Http\Controllers\AccountController::class, 'change'])->name('account.change.password');
                    Route::post('/resetpassword', [\App\Http\Controllers\AccountController::class, 'reset'])->name('account.reset.password');
                    Route::get('/rating', [\App\Http\Controllers\RatingController::class, 'index'])->name('rating');

                    Route::prefix('store')->group(function () {
                        Route::get('/', [\App\Http\Controllers\ShopController::class, 'index'])->name('shop');
                        Route::post('/cart/add', [\App\Http\Controllers\ShopController::class, 'add_cart'])->name('shop.cart.add');
                        Route::post('/cart/delete', [\App\Http\Controllers\ShopController::class, 'delete_cart'])->name('shop.cart.delete');
                        Route::post('/cart/update', [\App\Http\Controllers\ShopController::class, 'update_cart'])->name('shop.cart.update');
                        Route::get('/checkout', [\App\Http\Controllers\ShopController::class, 'checkout'])->name('shop.cart.checkout');
                        Route::post('/coupon/apply', [\App\Http\Controllers\ShopController::class, 'apply_coupon'])->name('shop.coupon.apply');
                        Route::post('/coupon/remove', [\App\Http\Controllers\ShopController::class, 'remove_coupon'])->name('shop.coupon.remove');
                        Route::post('/checkout', [\App\Http\Controllers\ShopController::class, 'complete'])->name('shop.cart.complete');
                        Route::get('/checkout/success', [\App\Http\Controllers\ShopController::class, 'success'])->name('shop.cart.success');
                        Route::get('/{shopitem}', [\App\Http\Controllers\ShopController::class, 'show'])->name('shop.item.show');
                    });

                    Route::prefix('promocodes')->group(function () {
                        Route::get('/', [\App\Http\Controllers\PromoCodeController::class, 'index'])->name('promocodes');
                        Route::post('/apply', [\App\Http\Controllers\PromoCodeController::class, 'apply'])->name('promocodes.apply');
                        Route::post('/check', [\App\Http\Controllers\PromoCodeController::class, 'check'])->name('promocodes.check');
                    });

                    Route::prefix('donate')->group(function () {
                        Route::get('/', [\App\Http\Controllers\DonateController::class, 'index'])->name('donate');
                        Route::any('/app', [\App\Http\Controllers\DonateController::class, 'index']);
                        Route::get('/transfer', [\App\Http\Controllers\DonateController::class, 'transfer'])->name('donate.transfer');
                        Route::post('/transfer', [\App\Http\Controllers\DonateController::class, 'transfer_store']);
                        Route::post('', [\App\Http\Controllers\DonateController::class, 'create']);
                    });

                    Route::prefix('tickets')->group(function () {
                        Route::get('/', [\App\Http\Controllers\TicketController::class, 'index'])->name('tickets');
                        Route::post('/', [\App\Http\Controllers\TicketController::class, 'store'])->name('tickets.store');
                        Route::get('/{ticket}/delete', [\App\Http\Controllers\TicketController::class, 'destroy'])->name('tickets.delete');
                        Route::post('/{ticket}/answer', [\App\Http\Controllers\TicketController::class, 'update'])->name('tickets.update');
                        Route::get('/{ticket}/solve', [\App\Http\Controllers\TicketController::class, 'solve'])->name('tickets.solve');
                        Route::get('/{ticket}/close', [\App\Http\Controllers\TicketController::class, 'close'])->name('tickets.close');
                        Route::get('/{ticket}', [\App\Http\Controllers\TicketController::class, 'show'])->name('tickets.show');
                    });

                    Route::prefix('settings')->group(function () {
                        Route::get('/security', [\App\Http\Controllers\UserSettingsController::class, 'security'])->name('settings.security');
                        Route::patch('/security', [\App\Http\Controllers\UserSettingsController::class, 'security_store']);

                        Route::get('/pin', [\App\Http\Controllers\UserSettingsController::class, 'pin'])->name('settings.pin');
                        Route::patch('/pin', [\App\Http\Controllers\UserSettingsController::class, 'pin_store']);
                        Route::post('/resetpin', [\App\Http\Controllers\UserSettingsController::class, 'reset_pin'])->name('settings.pin.reset');
                        Route::post('/setphone', [\App\Http\Controllers\UserSettingsController::class, 'set_phone'])->name('settings.phone.set');

                        Route::get('/profile', [\App\Http\Controllers\UserSettingsController::class, 'profile'])->name('settings.profile');
                        Route::patch('/profile', [\App\Http\Controllers\UserSettingsController::class, 'profile_store']);

                        Route::get('/activity', [\App\Http\Controllers\UserSettingsController::class, 'activity'])->name('settings.activity');
                        Route::get('/activity/{id}', [\App\Http\Controllers\UserSettingsController::class, 'activity_destroy'])->name('settings.activity.destroy');

                        Route::get('/activitylogs', [\App\Http\Controllers\LogController::class, 'index'])->name('activitylogs');

                        Route::post('/sendcode', [\App\Http\Controllers\UserSettingsController::class, 'sendcode'])->name('settings.sendcode');

                        Route::get('/profile_2fa', [\App\Http\Controllers\UserSettingsController::class, 'profile_2fa'])->name('settings.profile_2fa');
                        Route::post('/profile_2fa', [\App\Http\Controllers\UserSettingsController::class, 'set_profile_2fa'])->name('settings.profile_2fa.set');
                        Route::post('/get2FACode', [\App\Http\Controllers\UserSettingsController::class, 'get2FACode'])->name('settings.get2FACode');
                    });

                    Route::prefix('referrals')->group(function () {
                        Route::get('/', [\App\Http\Controllers\ReferralController::class, 'index'])->name('cabinet.referrals.index');
                        Route::post('/', [\App\Http\Controllers\ReferralController::class, 'store'])->name('cabinet.referrals.store');
                        Route::post('/getcode', [\App\Http\Controllers\ReferralController::class, 'getCode'])->name('cabinet.referrals.getcode');
                        Route::post('/setStatus', [\App\Http\Controllers\ReferralController::class, 'setStatus'])->name('cabinet.referrals.status.set');
                        Route::post('/{referral}/delete', [\App\Http\Controllers\ReferralController::class, 'destroy'])->name('cabinet.referrals.delete');
                    });

                    Route::get('/luckywheel', [\App\Http\Controllers\LuckywheelController::class, 'index'])->name('luckywheel.index');
                    Route::get('/getLuckyWheelItems', [\App\Http\Controllers\LuckywheelController::class, 'getLuckyWheelItems']);
                    Route::get('/getRewardLuckyWheelItem', [\App\Http\Controllers\LuckywheelController::class, 'getRewardLuckyWheelItem']);
                    Route::get('/getUserBalance', [\App\Http\Controllers\LuckywheelController::class, 'getUserBalance']);

                    Route::prefix('voting')->group(function () {
                        Route::get('/', [\App\Http\Controllers\VotingController::class, 'index'])->name('voting');
                        Route::get('/redirect/{voting_name}', [\App\Http\Controllers\VotingController::class, 'redirect'])->name('voting.redirect');
                    });

                    Route::prefix('market')->group(function () {
                        Route::get('/', [\App\Http\Controllers\MarketController::class, 'index'])->name('market.index');
                        Route::get('/marketitems/{marketitem}', [\App\Http\Controllers\MarketController::class, 'show'])->name('market.show');
                        Route::get('/category/{marketcategory}', [\App\Http\Controllers\MarketController::class, 'category'])->name('market.category');
                        Route::get('/mylots', [\App\Http\Controllers\MarketController::class, 'mylots'])->name('market.mylots');
                        Route::get('/history', [\App\Http\Controllers\MarketController::class, 'history'])->name('market.history');
                        Route::get('/sell', [\App\Http\Controllers\MarketController::class, 'sell'])->name('market.sell');
                        Route::post('/sellout', [\App\Http\Controllers\MarketController::class, 'sellout'])->name('market.sellout');
                        Route::post('/buyout', [\App\Http\Controllers\MarketController::class, 'buyout'])->name('market.buyout');
                        Route::get('/cancel/{marketitem}', [\App\Http\Controllers\MarketController::class, 'cancel'])->name('market.cancel');
                    });

                    Route::prefix('bazaar')->group(function () {
                        Route::get('', [\App\Http\Controllers\BazaarController::class, 'index'])->name('bazaar');
                        Route::post('', [\App\Http\Controllers\BazaarController::class, 'store'])->name('bazaar.store');
                        Route::get('/category/{category}', [\App\Http\Controllers\BazaarController::class, 'category'])->name('bazaar.category');
                        Route::get('/item/{item}', [\App\Http\Controllers\BazaarController::class, 'show'])->name('bazaar.item.show');
                        Route::post('/item/{item}/sell', [\App\Http\Controllers\BazaarController::class, 'sellout'])->name('bazaar.item.sell');
                        Route::post('/item/{item}/buy', [\App\Http\Controllers\BazaarController::class, 'buy'])->name('bazaar.item.buy');
                        Route::post('/item/{item}/delete', [\App\Http\Controllers\BazaarController::class, 'destroy'])->name('bazaar.item.delete');
                        Route::post('/item/{item}/cancel', [\App\Http\Controllers\BazaarController::class, 'cancel'])->name('bazaar.item.cancel');
                        Route::get('/user/{user}', [\App\Http\Controllers\BazaarController::class, 'history'])->name('bazaar.history');
                        Route::get('/mylots', [\App\Http\Controllers\BazaarController::class, 'mylots'])->name('bazaar.mylots');
                        Route::get('/history', [\App\Http\Controllers\BazaarController::class, 'history'])->name('bazaar.myhistory');
                        Route::get('/sell', [\App\Http\Controllers\BazaarController::class, 'sell'])->name('bazaar.sell');
                        //Route::get('/set_patch', [\App\Http\Controllers\BazaarController::class, 'setPatchItems'])->name('bazaar.setPatchItems');
                    });

                    Route::prefix('characters')->group(function () {
                        Route::get('/{account?}', [\App\Http\Controllers\CharacterController::class, 'index'])->name('characters');
                        Route::get('/teleport/{char_id}', [\App\Http\Controllers\CharacterController::class, 'teleport'])->name('characters.teleport');
                        Route::get('/inventory/{char_id}', [\App\Http\Controllers\CharacterController::class, 'inventory'])->name('characters.inventory');
                        Route::get('/inventory/transfer/{char_id}/{item_id}', [\App\Http\Controllers\CharacterController::class, 'transfer'])->name('characters.inventory.transfer');
                        Route::post('/inventory/transfer/{char_id}/{item_id}', [\App\Http\Controllers\CharacterController::class, 'transfer_store']);
                    });

                    Route::prefix('auction')->group(function () {
                        Route::get('/', [\App\Http\Controllers\AuctionController::class, 'index'])->name('auction.index');
                        Route::get('/{auction}', [\App\Http\Controllers\AuctionController::class, 'cancel'])->name('auction.cancel');
                        Route::post('/bet/{auction}', [\App\Http\Controllers\AuctionController::class, 'bet'])->name('auction.bet');
                        Route::get('/buyout/{auction}', [\App\Http\Controllers\AuctionController::class, 'buyout'])->name('auction.buyout');
                    });

                    Route::prefix('warehouse')->group(function () {
                        Route::get('/', [\App\Http\Controllers\WarehouseController::class, 'index'])->name('warehouse.index');
                        Route::get('/transfer/{warehouse}', [\App\Http\Controllers\WarehouseController::class, 'transfer'])->name('warehouse.transfer');
                        Route::post('/transfer/{warehouse}', [\App\Http\Controllers\WarehouseController::class, 'transfer_store']);
                        Route::get('/auction/{warehouse}', [\App\Http\Controllers\WarehouseController::class, 'auction'])->name('warehouse.auction');
                        Route::post('/auction/{warehouse}', [\App\Http\Controllers\WarehouseController::class, 'auction_store']);
                    });

                });

                Route::get('/bugs', [\App\Http\Controllers\ReportController::class, 'index'])->name('reports');
                Route::get('/changelog', [\App\Http\Controllers\ChangelogController::class, 'index'])->name('changelog');
                Route::get('/notes', [\App\Http\Controllers\ReleaseNotesController::class, 'index'])->name('releasenotes');

                Route::post('/notes', [\App\Http\Controllers\ReleaseNotesController::class, 'store'])->name('notes.store');

                Route::get('/email/verify', [EmailVerifyController::class, 'notice'])->name('verification.notice');
                Route::post('/email/notify', [EmailVerifyController::class, 'resend'])->middleware('throttle:6,1')->name('verification.resend');

            });

        });

        Route::get('/server/offline', function () {
            if (server_status(session('server_id')) === 'Online') {
                return redirect()->route('cabinet');
            }
            return view('errors.server-offline');
        })->name('server.offline');
    });

});
