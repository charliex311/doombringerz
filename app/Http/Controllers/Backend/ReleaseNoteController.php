<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\ReleaseNoteRequest;
use App\Models\ReleaseNote;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class ReleaseNoteController extends Controller
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
        $releasenotes = ReleaseNote::query();

        $search = request()->query('search');
        if (request()->has('search') && is_string($search)) {
            $releasenotes->where('title_', 'LIKE', "%{$search}%");
        }

        $releasenotes = $releasenotes->latest()->paginate();

        return view('backend.pages.releasenotes.index', compact('releasenotes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.pages.releasenotes.form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ReleaseNoteRequest $request)
    {

        $data = $request->validated();
        $this->alert('success', __('Релиз успешно добавлен'));

        ReleaseNote::create($data);
        return redirect()->route('releasenotes.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ReleaseNote $releasenote)
    {
        return view('backend.pages.releasenotes.form', compact('releasenote'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ReleaseNoteRequest $request, ReleaseNote $releasenote)
    {
        $data = $request->validated();

        $this->alert('success', __('Релиз успешно обновлен'));
        $releasenote->update($data);
        return redirect()->route('releasenotes.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ReleaseNote $releasenote)
    {
        $this->alert('success', __('Релиз успешно удален'));
        $releasenote->delete();
        return redirect()->route('releasenotes.index');
    }
}
