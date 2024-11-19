<?php
namespace App\Lib\GameServer;

interface GameServerInterface {

    public static function createGameAccount(object $account, string $salt, string $verifier, string $email, int $server_id);

    public static function getGameAccount(?string $login, int $server_id);

    public static function getCharacterByName($char_name);

    public static function getGameCharacters(?int $account_id, int $server_id);

    public static function getGameCharacter(?int $char_id, int $server_id);

    public static function getCharactersCount(?int $account_id, int $server_id);

    public static function getCharacters(?int $account_id, int $server_id);

    public static function checkNameCharacter($nickname);

    public static function teleportCharacterMainTown($char_id, $town_cord);

    public static function transferItemWarehouse($char_id, $item_id, $amount, $inventory);

    public static function transferItemGameServer($char_id, $character, $amount, $warehouse);

    public static function transferDonateGameServer($char_id, $character, $amount);

    public static function changeNameCharacter($char_id, $nickname);

    public static function changeColorCharacter($char_id, $type, $color);

    public static function searchGameAccountByCharacter($character);

    public static function getAccountHWID($account_name);

    public static function getOnlineCount($server_id);

    public static function getStatus($server_id);

}
