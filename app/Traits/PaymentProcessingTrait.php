<?php

namespace App\Traits;

use App\Http\Controllers\Controller;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\DonateController;
use Illuminate\Http\Request;
use App\Models\Donate;
use App\Models\User;
use Illuminate\Support\Facades\Log;

trait PaymentProcessingTrait {

    public function afterSuccessPay($donate, Request $request) {

        if ($donate->user_id !== 0) {
            $donateController = new DonateController;
            $donateController->transfer_balance($donate->coins, $donate->user_id);
            if ($donate->bonus_item_id > 0) {
                $donateController->transfer_item($donate->bonus_item_id, $donate->user_id);
            }
        } else {
            $donationController = new DonationController;
            $donationController->transfer_store($donate->coins, $donate->char_name);
            if ($donate->bonus_item_id > 0) {
                $donationController->transfer_item_store($donate->bonus_item_id, $donate->char_name);
            }
        }

        Log::channel('paymentslog')->info("Робот: Совершена покупка игровой валюты. Параметры:" . json_encode($donate->toArray()));
    }

}
