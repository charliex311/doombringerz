<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\MarketCategoryRequest as CategoryRequest;
use App\Models\MarketCategory as Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class MarketCategoryController extends Controller
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
        $marketcategories = Category::query();

        $search = request()->query('search');
        if (request()->has('search') && is_string($search)) {
            $marketcategories->where('title_', 'LIKE', "%{$search}%");
        }

        $marketcategories = $marketcategories->latest()->paginate();

        return view('backend.pages.market.categories.index', compact('marketcategories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.pages.market.categories.form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['image'] = $request->image->store('images', 'public');
        Category::create($data);

        $this->alert('success', __('Категория успешно добавлена'));
        return redirect()->route('marketcategories.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $marketcategory)
    {
        return view('backend.pages.market.categories.form', compact('marketcategory'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryRequest $request, Category $marketcategory): RedirectResponse
    {
        $data = $request->validated();

        if (isset($data['image'])) {
            Storage::disk('public')->delete($marketcategory->image);
            $data['image'] = $request->image->store('images', 'public');
        }
        $marketcategory->update($data);

        $this->alert('success', __('Категория успешно обновлена'));
        return redirect()->route('marketcategories.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $marketcategory)
    {
        Storage::disk('public')->delete($marketcategory->image);
        $marketcategory->delete();

        $this->alert('success', __('Категория успешно удалена'));
        return back();
    }
}
