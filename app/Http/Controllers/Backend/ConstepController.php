<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\ConstepRequest;
use App\Models\Constep;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class ConstepController extends Controller
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
        $consteps = Constep::query();

        $search = request()->query('search');
        if (request()->has('search') && is_string($search)) {
            $consteps->where('title_', 'LIKE', "%{$search}%");
        }

        $consteps = $consteps->latest()->paginate();

        return view('backend.pages.consteps.index', compact('consteps'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.pages.consteps.form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ConstepRequest $request): RedirectResponse
    {

        $data = $request->validated();
        $this->alert('success', __('Шаг успешно добавлен'));

        Constep::create($data);
        return redirect()->route('consteps.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Constep $constep)
    {
        return view('backend.pages.consteps.form', compact('constep'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ConstepRequest $request, Constep $constep): RedirectResponse
    {
        $data = $request->validated();

        $this->alert('success', __('Шаг успешно обновлен'));
        $constep->update($data);
        return redirect()->route('consteps.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Constep $constep)
    {
        $this->alert('success', __('Шаг успешно удален'));
        $constep->delete();
        return redirect()->route('consteps.index');
    }
}
