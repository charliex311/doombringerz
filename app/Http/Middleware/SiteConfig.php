<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Option;
use Illuminate\Support\Facades\Cache;

class SiteConfig
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */

    public function handle(Request $request, Closure $next)
    {

        $options = Cache::rememberForever('options', function () {
            return Option::all();
        });

        foreach ($options as $option) {
            config()->set("options.{$option->key}", $option->value);

            //Задаем конфиг recaptcha_v3 из настроек сайта
            if ($option->key === 'recaptcha_sitekey') {config(['recaptchav3.sitekey' => $option->value]);}
            elseif ($option->key === 'recaptcha_secret') {config(['recaptchav3.secret' => $option->value]);}
            //Задаем конфиг smtp из настроек сайта
            elseif ($option->key === 'smtp_host') {config(['mail.mailers.smtp.host' => $option->value]);}
            elseif ($option->key === 'smtp_port') {config(['mail.mailers.smtp.port' => $option->value]);}
            elseif ($option->key === 'smtp_user') {config(['mail.mailers.smtp.username' => $option->value]);}
            elseif ($option->key === 'smtp_password') {config(['mail.mailers.smtp.password' => $option->value]);}
            elseif ($option->key === 'smtp_from') {config(['mail.from.address' => $option->value]);}
            elseif ($option->key === 'smtp_name') {config(['mail.from.name' => $option->value]);}
            //Задаем конфиг форума
            elseif ($option->key === 'forum_link') {config(['database.connections.xenforo.url' => $option->value]);}
            elseif ($option->key === 'forum_type') {config(['database.connections.xenforo.url' => $option->value]);}
            elseif ($option->key === 'forum_host') {config(['database.connections.xenforo.host' => $option->value]);}
            elseif ($option->key === 'forum_port') {config(['database.connections.xenforo.port' => $option->value]);}
            elseif ($option->key === 'forum_database') {config(['database.connections.xenforo.database' => $option->value]);}
            elseif ($option->key === 'forum_username') {config(['database.connections.xenforo.username' => $option->value]);}
            elseif ($option->key === 'forum_password') {config(['database.connections.xenforo.password' => $option->value]);}
            //Задаем конфиг платежных систем
            elseif ($option->key === 'paypal_client_id') {config(['paypal.client_id' => $option->value]);}
            elseif ($option->key === 'paypal_secret') {config(['paypal.secret' => $option->value]);}
            //Задаем конфиг Socialite (Google Auth)
            elseif ($option->key === 'google_api_client_id') {config(['services.google.client_id' => $option->value]);}
            elseif ($option->key === 'google_api_client_secret') {config(['services.google.client_secret' => $option->value]);}
            elseif ($option->key === 'google_api_redirect') {config(['services.google.redirect' => $option->value]);}
            //Задаем конфиг Socialite (Discord)
            elseif ($option->key === 'discord_api_client_id') {config(['services.discord.client_id' => $option->value]);}
            elseif ($option->key === 'discord_api_client_secret') {config(['services.discord.client_secret' => $option->value]);}
            elseif ($option->key === 'discord_api_redirect') {config(['services.discord.redirect' => $option->value]);}
        }

        return $next($request);
    }
}
