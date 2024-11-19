<?php
namespace App\Lib;

use App\Lib\CacheD;
use App\Models\Account;
use App\Models\Characters;
use App\Models\Inventory;
use App\Models\Warehouse;
use App\Models\Auction;
use App\Models\UserDelivery;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;


class SOAP {

    public static function helpCommand()
    {

        $client = new \SoapClient(NULL, [
            'location'   => 'http://127.0.0.1:7878/', //Адрес подключения IP:PORT
            'uri'        => 'urn:TC', //Оставьте без изменений для TrinityCore
            'login'      => ' ', // Указывайте логин GM аккаунта
            'password'   => ' ', //Указывайте пароль GM аккаунта
            'style'      => SOAP_RPC,  //Оставьте без изменений
            'keep_alive' => FALSE  //Оставьте без изменений
        ]);

        $result = $client->executeCommand(
            new \SoapParam('help', "command")
        );

    }

}
