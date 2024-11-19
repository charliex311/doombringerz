<?php

namespace App\Http\Controllers;

use App\Lib\GameServer;
use App\Models\Account;
use App\Models\Auction;
use App\Models\Characters;
use App\Models\UserDelivery;
use App\Models\Warehouse;
use App\Models\Referral;
use App\Http\Requests\ReferralRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class ReferralController extends Controller
{
    public function __construct()
    {
        $this->middleware('server.status')->only(['transfer', 'transfer_store']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $referral = Referral::query()->where('user_id', auth()->id())->first();
        if (!$referral) {
            $referral = new Referral;
            $referral->status = 1;
            $referral->code = generationReferralCode();
            $referral->user()->associate(auth()->user());
            $referral->total = 0;
            $referral->history = json_encode([]);
            $referral->users = json_encode([]);
            $referral->save();
        }

        $leaders = Referral::query()->orderByDesc('total')->limit(10)->get();

        return view('pages.cabinet.referrals.index', compact('referral', 'leaders'));
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
        if (auth()->user()->can('support')) {
            $referral->forceDelete();
        } else if (auth()->id() === $referral->user_id) {
            $referral->delete();
        }

        return back();
    }


    public function getCode()
    {
        for ($i=0;$i<20;$i++) {
            $ref_code = generationReferralCode();
            if (!Referral::find($ref_code)) {
                break;
            }
        }
        return $ref_code;
    }

    public function setRefSession($ref)
    {
        session()->put('ref_code', $ref);

        return Redirect::to(route('register'));
    }

    public function setStatus(Request $request)
    {
        $referral = Referral::query()->where('user_id', auth()->id())->first();

        if ($referral && $request->has('status')) {
            if ($request->input('status') == '0') {
                $referral->status = 0;
            } else {
                $referral->status = 1;
            }
            $referral->save();
        }

        return response()->json([
            'status' => 'success',
            'msg' => $referral->status
        ]);
    }

}
