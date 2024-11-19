<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\ReleaseRequest;
use App\Models\Release;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class ReleaseController extends Controller
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
        $releases = Release::query();

        $search = request()->query('search');
        if (request()->has('search') && is_string($search)) {
            $releases->where('title_', 'LIKE', "%{$search}%");
        }

        $releases = $releases->latest()->paginate();

        return view('backend.pages.releases.index', compact('releases'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.pages.releases.form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ReleaseRequest $request)
    {
        //Сохраняем группы и записи
        $road_groups = [];
        for ($g=1; $g<10; $g++) {
            if ($request->input('road_donat_' . $g . '_groups') !== NULL) {
                $road_groups[$g]['id'] = $request->input('road_donat_' . $g . '_groups');

                $road_items = [];
                for ($i = 1; $i < 10; $i++) {
                    if ($request->input('road_bitem_' . $g . '_' . $i . '_title_en') !== NULL) {
                        $road_items[$i]['title_en'] = $request->input('road_bitem_' . $g . '_' . $i . '_title_en');
                        $road_items[$i]['title_ru'] = $request->input('road_bitem_' . $g . '_' . $i . '_title_ru');
                        $road_items[$i]['description_en'] = $request->input('road_bitem_' . $g . '_' . $i . '_description_en');
                        $road_items[$i]['description_ru'] = $request->input('road_bitem_' . $g . '_' . $i . '_description_ru');
                        $road_items[$i]['short_description_en'] = $request->input('road_bitem_' . $g . '_' . $i . '_short_description_en');
                        $road_items[$i]['short_description_ru'] = $request->input('road_bitem_' . $g . '_' . $i . '_short_description_ru');
                        $image = 'road_bitem_' . $g . '_' . $i . '_image';
                        if (is_file($request->$image)) {
                            $road_items[$i]['image'] = $request->$image->store('images', 'public');
                        } else {
                            $image_old = 'road_bitem_' . $g . '_' . $i . '_image_old';
                            $road_items[$i]['image'] = $request->$image_old;
                        }
                    }
                }

                $road_groups[$g]['items'] = $road_items;
            }
        }

        $data = $request->validated();
        $data['road_groups'] = json_encode($road_groups);

        $data = $request->validated();

        $data['image'] = $request->image->store('images', 'public');
        $this->alert('success', __('Релиз успешно добавлен'));

        Release::create($data);
        return redirect()->route('releases.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Release $release)
    {
        return view('backend.pages.releases.form', compact('release'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ReleaseRequest $request, Release $release)
    {
        //Сохраняем группы и записи
        $road_groups = [];
        for ($g=1; $g<10; $g++) {
            if ($request->input('road_donat_' . $g . '_groups') !== NULL) {
                $road_groups[$g]['id'] = $request->input('road_donat_' . $g . '_groups');

                $road_items = [];
                for ($i = 1; $i < 10; $i++) {
                    if ($request->input('road_bitem_' . $g . '_' . $i . '_title_en') !== NULL) {
                        $road_items[$i]['title_en'] = $request->input('road_bitem_' . $g . '_' . $i . '_title_en');
                        $road_items[$i]['title_ru'] = $request->input('road_bitem_' . $g . '_' . $i . '_title_ru');
                        $road_items[$i]['description_en'] = $request->input('road_bitem_' . $g . '_' . $i . '_description_en');
                        $road_items[$i]['description_ru'] = $request->input('road_bitem_' . $g . '_' . $i . '_description_ru');
                        $road_items[$i]['short_description_en'] = $request->input('road_bitem_' . $g . '_' . $i . '_short_description_en');
                        $road_items[$i]['short_description_ru'] = $request->input('road_bitem_' . $g . '_' . $i . '_short_description_ru');
                        $image = 'road_bitem_' . $g . '_' . $i . '_image';
                        if (is_file($request->$image)) {
                            $road_items[$i]['image'] = $request->$image->store('images', 'public');
                        } else {
                            $image_old = 'road_bitem_' . $g . '_' . $i . '_image_old';
                            $road_items[$i]['image'] = $request->$image_old;
                        }
                    }
                }

                $road_groups[$g]['items'] = $road_items;
            }
        }

        $data = $request->validated();
        $data['road_groups'] = json_encode($road_groups);

        if (isset($data['image'])) {
            Storage::disk('public')->delete($release->image);
            $data['image'] = $request->image->store('images', 'public');
        }

        $this->alert('success', __('Релиз успешно обновлен'));
        $release->update($data);
        return redirect()->route('releases.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Release $release)
    {
        $this->alert('success', __('Релиз успешно удален'));
        Storage::disk('public')->delete($release->image);
        $release->delete();
        return redirect()->route('releases.index');
    }
}
