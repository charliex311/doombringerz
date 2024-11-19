<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\ReferralRequest;
use App\Models\Referral;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class ReferralController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('can:investor');
        $this->middleware('can:admin')->only(['create', 'edit', 'store', 'update', 'destroy']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $referrals = Referral::query();

        $search = request()->query('search');
        if (request()->has('search') && is_string($search)) {
            $referrals->where('code', 'LIKE', "%{$search}%");
        }

        $referrals = $referrals->latest()->paginate();

        return view('backend.pages.referrals.index', compact('referrals'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function show(Referral $referral)
    {
        return view('backend.pages.referrals.full', compact('referral'));
    }

    public function store(ReferralRequest $request, Referral $referral)
    {
        $data = $request->validated();

        $referral->fill($data);
        $referral->status = 1;
        $referral->user()->associate(auth()->user());
        $referral->total = 0;
        $referral->history = json_encode([]);
        $referral->save();

        $this->alert('success', __('Вы успешно создали реферальный код!'));

        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Referral $referral)
    {
        $this->alert('success', __('Реферальный код успешно удален!'));
        $referral->delete();
        return back();
    }
}
