<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\VideoRequest;
use App\Lib\CacheD;
use App\Models\Video;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class VideoController extends Controller
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
//         $req = new CacheD;
//        dd($req->KickCharacterPacket(2), $req->AddItem2Packet(2,0,6673,500,0, 0, 0, 0));
//        dd($req->KickCharacterPacket(2), $req->DelItemPacketGF(2,0,18680,10));
//        dd($req->SetNameColor(0, 2, 0, 13353215));
        $videos = Video::query();

        $search = request()->query('search');
        if (request()->has('search') && is_string($search)) {
            $videos->where('title', 'LIKE', "%{$search}%");
        }

        $videos = $videos->latest()->paginate();

        return view('backend.pages.videos.index', compact('videos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.pages.videos.form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(VideoRequest $request): RedirectResponse
    {
        $data = $request->validated();

        if (isset($data['image'])) {
            $data['image'] = $request->image->store('videos', 'public');
        }

        Video::create($data);
        $this->alert('success', __('Новое видео успешно добавлено'));
        return redirect()->route('videos.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Video $video)
    {
        return view('backend.pages.videos.form', compact('video'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(VideoRequest $request, Video $video): RedirectResponse
    {
        $data = $request->validated();

        if (isset($data['image'])) {
            Storage::disk('public')->delete($video->image);
            $data['image'] = $request->image->store('videos', 'public');
        }

        $this->alert('success', __('Видео успешно обновлено'));
        $video->update($data);
        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Video $video): RedirectResponse
    {
        $this->alert('success', __('Видео успешно удалено'));
        Storage::disk('public')->delete($video->image);
        $video->delete();
        return back();
    }
}
