<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReportRequest;
use App\Http\Requests\ReportReplyRequest;
use App\Models\Report;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Lib\GameServer;

class ReportController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('can:support')->only(['support', 'backend_show', 'backend_answer', 'backend_isread', 'backend_change_status', 'backend_update_reply', 'backend_edit', 'backend_update']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reports = Report::query();

        if (request()->has('search')) {
            $reports->where('title', 'LIKE', "%" . request()->query('search'). "%");
        }

        /*
        if (request()->has('priority_id') && request()->query('priority_id') > 0) {
            $reports->where('priority', request()->query('priority_id'));
        }
        */

        if (request()->has('status_id') && request()->query('status_id') > 0) {
            $reports->where('status', request()->query('status_id'));
        } else  {
            $reports->where('status', '!=', '7')->where('status', '!=', '8');
        }

        if (request()->has('category_id') && request()->query('category_id') > 0) {
            $reports->where('category_id', request()->query('category_id'));
            if (request()->query('category_id') == 5) { //Exploits
                if (isset(auth()->user()->id)) {
                    if (auth()->user()->role != 'admin' && auth()->user()->role != 'support') {
                        $reports->where('user_id', auth()->user()->id);
                    }
                } else {
                    $reports->where('user_id', '-1');
                }

            }
        } else {
            if (isset(auth()->user()->id)) {
                if (auth()->user()->role != 'admin' && auth()->user()->role != 'support') {
                    $reports->where('category_id', '!=', '5')
                        ->OrWhere('user_id', auth()->user()->id);
                }
            } else {
                $reports->where('category_id', '!=', '5');
            }
        }
        if (request()->has('subcategory_id') && request()->query('subcategory_id') > 0) {
            $reports->where('subcategory_id', request()->query('subcategory_id'));
        }
        if (request()->has('subcategory_id') && request()->query('subcategory_id') > 0) {
            $reports->where('subcategory_id', request()->query('subcategory_id'));
        }
        if (request()->has('my') && request()->query('my') > 0 && auth()->user()) {
            $reports->where('user_id', auth()->user()->id);
        }
        if (request()->has('opened') && request()->query('opened') > 0) {
            $reports->whereIN('status', ['1', '2', '4']); //Pending, Confirmed, Testing fix
        }
        if (request()->has('closed') && request()->query('closed') > 0) {
            $reports->whereIN('status', ['3', '5']); //Fixed, Invalid/duplicate
        }

        if (request()->has('priority_id') && request()->query('priority_id') > 0) {
            if (request()->query('priority_id') == 1) {
                $reports->orderByDesc('like');
            } elseif (request()->query('priority_id') == 2) {
                $reports->orderBy('created_at');
            } elseif (request()->query('priority_id') == 3) {
                $reports->orderByDesc('replicate');
            }
        } else {
            $reports->latest();
        }
        $reports = $reports->paginate(10);

        return view('pages.main.reports.list', compact('reports'));
    }

    /**
     * Display a listing of the resource for support manager.
     */
    public function support(Request $request)
    {

        $reports_status = $request->has('status') ? $request->get('status') : '0';

        $reports = Report::query();
        if ($reports_status > 0) {
            $reports->where('status', $reports_status);
        } else  {
            $reports->where('status', '!=', '7')->where('status', '!=', '8');
        }

        $reports = $reports->latest()->paginate();

        return view('backend.pages.reports.list', compact('reports', 'reports_status'));
    }

    public function create(Request $request)
    {
        if (auth()->user()->wow_id != 0) {
            $characters = GameServer::getGameCharacters(auth()->user()->wow_id);
        } else {
            $characters = [];
        }

        return view('pages.cabinet.reports.create', compact('characters'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ReportRequest $request)
    {

        $data = $request->validated();

        if (isset($data['attachment'])) {
            $data['attachment'] = $request->attachment->store('attachments', 'public');
        }

        $report = new Report;
        $report->fill($data);
        $report->uuid = Str::uuid();
        $report->status = 1;
        $report->steps = json_encode($data['step']);
        $report->user()->associate(auth()->user());
        $history = [];
        $history[] = [
            "text" => $request->input('question'),
            "user_id" => auth()->user()->id,
            "updated_at" => date('d.m.Y H:i'),
            "type" => 'question',
        ];
        $report->history = json_encode($history);
        $report->save();

        $this->alert('success', __('Вы успешно отправили запрос о баге'));
        return redirect()->route('reports');
    }

    /**
     * Display the specified resource.
     */
    public function show(Report $report)
    {

        $report->load(['user', 'answerer']);

            if ($report->category_id == 5) { //Exploits
                if (isset(auth()->user()->id)) {
                    if (auth()->user()->id != $report->user_id && auth()->user()->role != 'admin' && auth()->user()->role != 'support') {
                        abort(404);
                    }
                } else {
                    abort(404);
                }

            }

        $histories = ($report->history !== NULL) ? json_decode($report->history) : [];
        $steps = ($report->steps !== NULL) ? json_decode($report->steps) : [];

        return view('pages.main.reports.full', compact('report', 'histories', 'steps'));
    }

    public function like(Request $request, Report $report)
    {
        $count = 0;
        $users = json_decode($report->like_users);
        if($users === NULL) $users = [];

        if (!in_array(auth()->user()->id, $users)) {
            array_push($users, auth()->user()->id);
            $report->like_users = json_encode($users);
            if ($request->like == 'like') {
                $report->like++;
                $count = $report->like;
            } elseif ($request->like == 'dislike') {
                $report->dislike++;
                $count = $report->dislike;
            }
            $report->save();

            return response()->json([
                'status' => 'success',
                'count' => $count
            ]);
        }

        return response()->json([
            'status' => 'error',
            'msg' => __(''),
        ]);
    }

    public function replicate(Request $request, Report $report)
    {
        $users = json_decode($report->replicate_users);
        if($users === NULL) $users = [];

        if (!in_array(auth()->user()->id, $users)) {
            array_push($users, auth()->user()->id);
            $report->replicate_users = json_encode($users);
            $report->replicate++;
            $report->save();

            return response()->json([
                'status' => 'success',
                'count' => $report->replicate
            ]);
        }

        return response()->json([
            'status' => 'error',
            'msg' => __(''),
        ]);
    }

    public function edit(Request $request, Report $report)
    {
        if($report->user_id != auth()->user()->id) {
            return back();
        }

        $report->load(['user', 'answerer']);

        if (auth()->user()->wow_id != 0) {
            $characters = GameServer::getGameCharacters(auth()->user()->wow_id);
        } else {
            $characters = [];
        }

        return view('pages.cabinet.reports.edit', compact('report','characters'));
    }

    public function update(ReportRequest $request, Report $report)
    {
        if($report->user_id != auth()->user()->id && $report->status != 1) {
            $this->alert('danger', __('Ошибка! Попробуйте позже.'));
            return back();
        }

        $data = $request->validated();

        if (isset($data['attachment'])) {
            Storage::disk('public')->delete($report->attachment);
            $data['attachment'] = $request->attachment->store('attachments', 'public');
        }

        $report->update($data);

        $this->alert('success', __('Вы успешно обновили свое сообщение!'));
        return back();
    }

    public function reply(ReportReplyRequest $request, Report $report)
    {
        if( $report->trashed()) {
            $this->alert('danger', __('Ошибка! Попробуйте позже.'));
            return back();
        }

        if ($request->input('answer')) {

            if ($request->has('attachment')) {
                $attachment = $request->attachment->store('attachments', 'public');
            }

            $history = json_decode($report->history);
            $history[] = array(
                "text" => $request->input('answer'),
                "user_id" => auth()->user()->id,
                "updated_at" => date('d.m.Y H:i'),
                "type" => 'question',
                "attachment" => $attachment ?? '',
            );
            $report->history = json_encode($history);

            $report->answerer()->associate(auth()->user());
            $report->save();
        }

        $this->alert('success', __('Вы успешно добавили сообщение!'));
        return back();
    }

    public function update_reply(Request $request, Report $report)
    {
        if($report->user_id != auth()->user()->id && $report->trashed()) {
            $this->alert('danger', __('Ошибка! Попробуйте позже.'));
            return back();
        }

        if($report->history !== NULL) {
            $histories = json_decode($report->history);
        }

        $histories_upd = [];
        $index = 0;
        foreach($histories as $history) {
            $index++;
            if ($request->reply_index == $index && $history->type == 'question') {
                $history->text = $request->reply;
            }
            $histories_upd[] = $history;
        }

        $report->history = json_encode($histories_upd);
        $report->save();

        $this->alert('success', __('Вы успешно обновили свое сообщение!'));
        return back();
    }

    public function backend_show(Report $report)
    {
        $report->load(['user', 'answerer']);

        return view('backend.pages.reports.full', compact('report'));
    }

    public function backend_answer(Request $request, Report $report)
    {
        if ($request->input('answer')) {

            $history = json_decode($report->history);
            $history[] = array(
                "text" => $request->input('answer'),
                "user_id" => auth()->user()->id,
                "updated_at" => date('d.m.Y H:i'),
                "type" => 'answer',
            );
            $report->history = json_encode($history);
            $report->answerer()->associate(auth()->user());
            $report->is_read = '1';
            $report->save();
        }

        return back();
    }

    public function backend_isread(Request $request, Report $report)
    {
        $report->is_read = '1';
        $report->save();

        return back();
    }

    public function backend_update_reply(Request $request, Report $report)
    {
        if($report->history !== NULL) {
            $histories = json_decode($report->history);
        }

        $histories_upd = [];
        $index = 0;
        foreach($histories as $history) {
            $index++;
            if ($request->reply_index == $index) {
                $history->text = $request->reply;
            }
            $histories_upd[] = $history;
        }

        $report->history = json_encode($histories_upd);
        $report->save();

        $this->alert('success', __('Вы успешно обновили сообщение!'));
        return back();
    }

    public function backend_edit(Request $request, Report $report)
    {
        $report->load(['user', 'answerer']);

        $user = User::find($report->user_id);

        if ($user->wow_id != 0) {
            $characters = GameServer::getGameCharacters($user->wow_id);
        } else {
            $characters = [];
        }

        return view('backend.pages.reports.form', compact('report','characters'));
    }

    public function backend_update(ReportRequest $request, Report $report)
    {
        $data = $request->validated();

        if (isset($data['attachment'])) {
            Storage::disk('public')->delete($report->attachment);
            $data['attachment'] = $request->attachment->store('attachments', 'public');
        }

        $report->update($data);

        $this->alert('success', __('Вы успешно обновили сообщение!'));
        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Report $report)
    {
        if (auth()->user()->can('support')) {
            $report->forceDelete();
            if ($report->attachment) {
                Storage::disk('public')->delete($report->attachment);
            }
        } else {
            $report->delete();
        }

        return back();
    }

    public function change_status(Request $request)
    {
        $report_id = intval($request->input('report_id'));
        $report = Report::find($report_id);
        if (!$report) {
            $this->alert('danger', __('Произошла ошибка! Попробуйте позже.'));
            return back();
        }
        $report->status = $request->input('status');
        if ($request->has('link_trello') && $request->has('link_trello') != '') {
            $report->link_trello = $request->input('link_trello');
        }

        $history = json_decode($report->history);
        $history[] = array(
            "text" => auth()->user()->name ." changed this bug report's status to: " . getReportStatusNameById($report->status) . ".",
            "user_id" => auth()->id(),
            "updated_at" => date('d.m.Y H:i'),
            "type" => 'answer',
        );
        $report->history = json_encode($history);
        $report->answerer()->associate(auth()->user());
        $report->is_read = '1';
        $report->save();

        $this->alert('success', __('Вы успешно изменили статус репорта!'));
        return back();
    }

    public function lock(Report $report): RedirectResponse
    {
        $report->is_lock = 1;
        $report->save();

        Log::channel('adminlog')->info(auth()->user()->role . " " . auth()->user()->name . ": Lock report ID: {$report->id}");
        $this->alert('success', __('Вы успешно заблокировали обращение ID') . ': ' . $report->id);
        return back();
    }

    public function unlock(Report $report): RedirectResponse
    {
        $report->is_lock = 0;
        $report->save();

        Log::channel('adminlog')->info(auth()->user()->role . " " . auth()->user()->name . ": Unlock report ID: {$report->id}");
        $this->alert('success', __('Вы успешно разблокировали обращение ID') . ': '. $report->id);
        return back();
    }
}
