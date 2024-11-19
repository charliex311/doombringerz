<?php

namespace App\Http\Middleware;

use App;
use Closure;
use Illuminate\Http\Request;
use App\Models\Server;
use App\Models\Option;

class ServerConfig
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
        if (!session()->has('server_id')) {
            session()->put('server_id', '1');
        }
        $server = Server::where('id', session('server_id'))->first();
        if (!$server) {
            session()->put('server_id', '1');
            $server = Server::find(1);
        }

        if (isset($server->options)) {
            $options = json_decode($server->options);

            //Записываем в конфиг подключения значения для текущего сервера
            config(['database.ip' => $options->ip]);
            config(['database.wowword_db_type' => $options->wowword_db_type]);
            config(['database.connections.wowdb.host' => $options->wowdb_host]);
            config(['database.connections.wowdb.port' => $options->wowdb_port]);
            config(['database.connections.wowdb.database' => $options->wowdb_database]);
            config(['database.connections.wowdb.username' => $options->wowdb_username]);
            config(['database.connections.wowdb.password' => $options->wowdb_password]);
            config(['database.connections.wowworld.host' => $options->wowworld_host]);
            config(['database.connections.wowworld.port' => $options->wowworld_port]);
            config(['database.connections.wowworld.database' => $options->wowworld_database]);
            config(['database.connections.wowworld.username' => $options->wowworld_username]);
            config(['database.connections.wowworld.password' => $options->wowworld_password]);
        }

        return $next($request);
    }
}
