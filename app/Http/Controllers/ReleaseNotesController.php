<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReleaseNoteMainRequest;
use App\Models\ReleaseNote;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ReleaseNotesController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function index()
    {
        $releasenotes_qr = ReleaseNote::query()->where('status', 1);

        $category_id = (request()->has('category_id')) ? request()->query('category_id') : 0;
        if ($category_id > 0) {
            $releasenotes_qr->where('category_id', $category_id);
        }

        $date_start = (request()->has('date_start') && request()->query('date_start') !== NULL) ? date('Y-m-d 00:00:00', strtotime(request()->query('date_start'))) : '';
        if ($date_start != '') {
            $releasenotes_qr->where('date', '>=', $date_start);
        }

        $date_end = (request()->has('date_end') && request()->query('date_end') !== NULL) ? date('Y-m-d 23:59:59', strtotime(request()->query('date_end'))) : '';
        if ($date_end != '') {
            $releasenotes_qr->where('date', '<=', $date_end);
        }

        $releasenotes_qr = $releasenotes_qr->latest('date')->get();


        $releasenotes = [];
        foreach ($releasenotes_qr as $releasenote) {
            $releasenotes[$releasenote->date][] = $releasenote;
        }

        return view('pages.main.releasenotes', compact('releasenotes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ReleaseNoteMainRequest $request)
    {
        $data = $request->validated();

        $release_note = new ReleaseNote;
        $release_note->fill($data);
        $release_note->status = 1;
        $release_note->title_ru = $request->title_en;
        $release_note->description_ru = $request->description_en;
        $release_note->user_id = auth()->id();
        $release_note->save();

        $this->alert('success', __('Вы успешно добавили новый релиз лог'));
        return redirect()->route('releasenotes');
    }
}
