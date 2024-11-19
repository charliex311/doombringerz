<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\BazaarCategoryRequest;
use App\Models\BazaarCategory;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class BazaarCategoryController extends Controller
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
        $bazaarcategories = BazaarCategory::query();

        $search = request()->query('search');
        if (request()->has('search') && is_string($search)) {
            $bazaarcategories->where('title_', 'LIKE', "%{$search}%");
        }

        $bazaarcategories = $bazaarcategories->latest()->paginate();

        return view('backend.pages.bazaar.categories.index', compact('bazaarcategories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.pages.bazaar.categories.form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BazaarCategoryRequest $request): RedirectResponse
    {
        $data = $request->validated();
        if (isset($data['image'])) {
            $data['image'] = $request->image->store('images', 'public');
        } else {
            $data['image'] = '';
        }
        BazaarCategory::create($data);

        $this->alert('success', __('Категория успешно добавлена'));
        return redirect()->route('bazaarcategories.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BazaarCategory $bazaarcategory)
    {
        return view('backend.pages.bazaar.categories.form', compact('bazaarcategory'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BazaarCategoryRequest $request, BazaarCategory $bazaarcategory): RedirectResponse
    {
        $data = $request->validated();

        if (isset($data['image'])) {
            Storage::disk('public')->delete($bazaarcategory->image);
            $data['image'] = $request->image->store('images', 'public');
        }
        $bazaarcategory->update($data);

        $this->alert('success', __('Категория успешно обновлена'));
        return redirect()->route('bazaarcategories.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BazaarCategory $bazaarcategory)
    {
        Storage::disk('public')->delete($bazaarcategory->image);
        $bazaarcategory->delete();

        $this->alert('success', __('Категория успешно удалена'));
        return back();
    }
}
