<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\FeatureRequest;
use App\Models\Feature;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class FeatureController extends Controller
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
        $features = Feature::query();

        $search = request()->query('search');
        if (request()->has('search') && is_string($search)) {
            $features->where('title_', 'LIKE', "%{$search}%");
        }

        $features = $features->latest()->paginate();

        return view('backend.pages.features.index', compact('features'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.pages.features.form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(FeatureRequest $request)
    {
        $data = $request->validated();

        $data['image'] = $request->image->store('images', 'public');
        Feature::create($data);

        $this->alert('success', __('Особенность успешно добавлена'));
        return redirect()->route('features.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Feature $feature)
    {
        return view('backend.pages.features.form', compact('feature'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(FeatureRequest $request, Feature $feature): RedirectResponse
    {
        $data = $request->validated();

        if (isset($data['image'])) {
            Storage::disk('public')->delete($feature->image);
            $data['image'] = $request->image->store('images', 'public');
        }

        $feature->update($data);

        $this->alert('success', __('Особенность успешно обновлена'));
        return redirect()->route('features.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Feature $feature)
    {
        Storage::disk('public')->delete($feature->image);
        $feature->delete();

        $this->alert('success', __('Особенность успешно удалена'));
        return redirect()->route('features.index');
    }
}
