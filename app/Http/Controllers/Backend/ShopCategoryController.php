<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\ShopCategoryRequest as CategoryRequest;
use App\Models\ShopCategory as Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class ShopCategoryController extends Controller
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
    public function index(Request $request)
    {
        $shopcategories = Category::query();

        $main_category_id = $request->has('cat') ? $request->get('cat') : '0';

        $search = request()->query('search');
        if (request()->has('search') && is_string($search)) {
            $shopcategories->where('title_', 'LIKE', "%{$search}%");
        }

        if ($main_category_id > 0) {
            $shopcategories->where('main_category_id', $main_category_id);
        }

        $shopcategories = $shopcategories->latest()->paginate();

        return view('backend.pages.shop.categories.index', compact('shopcategories', 'main_category_id'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.pages.shop.categories.form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request): RedirectResponse
    {
        $data = $request->validated();

        Category::create($data);
        $this->alert('success', __('Категория успешно добавлена'));

        return redirect()->route('shopcategories.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $shopcategory)
    {
        return view('backend.pages.shop.categories.form', compact('shopcategory'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryRequest $request, Category $shopcategory): RedirectResponse
    {
        $data = $request->validated();

        $shopcategory->update($data);
        $this->alert('success', __('Категория успешно обновлена'));

        return redirect()->route('shopcategories.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $shopcategory)
    {
        $shopcategory->delete();
        $this->alert('success', __('Категория успешно удалена'));

        return back();
    }
}
