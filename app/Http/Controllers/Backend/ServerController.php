<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\ServerRequest;
use App\Models\Server;
use App\Models\Option;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class ServerController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('can:admin');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $servers = Server::query();

        $search = request()->query('search');
        if (request()->has('search') && is_string($search)) {
            $servers->where('name', 'LIKE', "%{$search}%");
        }

        $servers = $servers->latest()->paginate();

        return view('backend.pages.servers.index', compact('servers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.pages.servers.form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ServerRequest $request): RedirectResponse
    {
        $req = $request->validated();
        $options = array(
            "ip" => $req["ip"],
            "wowword_db_type" => $req["wowword_db_type"],
            "wowdb_host" => $req["wowdb_host"],
            "wowdb_port" => $req["wowdb_port"],
            "wowdb_database" => $req["wowdb_database"],
            "wowdb_username" => $req["wowdb_username"],
            "wowdb_password" => $req["wowdb_password"],
            "wowworld_host" => $req["wowworld_host"],
            "wowworld_port" => $req["wowworld_port"],
            "wowworld_database" => $req["wowworld_database"],
            "wowworld_username" => $req["wowworld_username"],
            "wowworld_password" => $req["wowworld_password"],
            "soap_uri" => $req["soap_uri"],
            "soap_login" => $req["soap_login"],
            "soap_password" => $req["soap_password"],
            "soap_style" => $req["soap_style"],
        );
        $data = array(
          "name" => $req["name"],
          "status" => $req["status"],
          "options"=> json_encode($options),
        );

        $this->alert('success', __('Сервер успешно добавлен'));
        Log::channel('adminlog')->info('Admin ' . auth()->user()->name . ': Server added successfully. Parameters: ' . json_encode($request->all()));

        Server::create($data);
        return redirect()->route('servers.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Server $server)
    {
        return view('backend.pages.servers.form', compact('server'));
    }

    public function settings($id)
    {
        $server = Server::where('id', $id)->first();
        return view('backend.pages.servers.settings', compact('server'));
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(ServerRequest $request, Server $server): RedirectResponse
    {
        $req = $request->validated();

        $options = array(
            "ip" => $req["ip"],
            "wowword_db_type" => $req["wowword_db_type"],
            "wowdb_host" => $req["wowdb_host"],
            "wowdb_port" => $req["wowdb_port"],
            "wowdb_database" => $req["wowdb_database"],
            "wowdb_username" => $req["wowdb_username"],
            "wowdb_password" => $req["wowdb_password"],
            "wowworld_host" => $req["wowworld_host"],
            "wowworld_port" => $req["wowworld_port"],
            "wowworld_database" => $req["wowworld_database"],
            "wowworld_username" => $req["wowworld_username"],
            "wowworld_password" => $req["wowworld_password"],
            "soap_uri" => $req["soap_uri"],
            "soap_login" => $req["soap_login"],
            "soap_password" => $req["soap_password"],
            "soap_style" => $req["soap_style"],
        );
        $data = array(
            "name" => $req["name"],
            "status" => $req["status"],
            "options"=> json_encode($options),
        );

        $this->alert('success', __('Сервер успешно обновлен'));
        Log::channel('adminlog')->info('Admin ' . auth()->user()->name . ': The server has been successfully updated. Parameters: ' . json_encode($request->all(), JSON_UNESCAPED_UNICODE));

        $server->update($data);
        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Server $server)
    {
        $this->alert('success', __('Сервер успешно удален'));
        Log::channel('adminlog')->info('Admin ' . auth()->user()->name . ': The server was successfully removed. Parameters:' . json_encode($server->name));

        $server->delete();
        return back();
    }
}
