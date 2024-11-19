<?php

namespace App\Http\Controllers;

use App\Http\Requests\TicketRequest;
use App\Http\Requests\TicketUpdateRequest;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class TicketController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('can:support')->only(['support', 'update', 'backend_show', 'backend_update', 'backend_isread', 'backend_close', 'backend_update_reply', 'backend_update_question']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (auth()->user()->isGMAdmin()) {
            $tickets = Ticket::with('user')->latest()->paginate();
        } else {
            $tickets = Ticket::with('user')->where('user_id', auth()->id())->latest()->paginate();
        }


        $counts = (object)[
            'total' => Ticket::count(),
            'open' => Ticket::whereIn('status', [1,2,3,4,5])->count(),
            'unread' => Ticket::where('is_read', 0)->count(),
            'delete' => Ticket::onlyTrashed()->count(),
        ];

        return view('pages.cabinet.tickets.list', compact('tickets', 'counts'));
    }

    /**
     * Display a listing of the resource for support manager.
     */
    public function support(Request $request)
    {

        $tickets = Ticket::query()->with('user');

        $search = request()->query('search');
        if (request()->has('search') && is_string($search)) {
            $users = User::where('email', 'LIKE', "%{$search}%")->orWhere('name', 'LIKE', "%{$search}%")->get()->pluck('id');
            $tickets->whereIn('user_id', $users);
        }

        $search_in = request()->query('search_in');
        if (request()->has('search_in') && is_string($search_in)) {
            $tickets->where(function($query) use ($search_in){
                $query->where('title', 'LIKE', "%{$search_in}%")->orWhere('question', 'LIKE', "%{$search_in}%")->orWhere('answer', 'LIKE', "%{$search_in}%")->orWhere('history', 'LIKE', "%{$search_in}%");
            });
        }

        $tickets_status = $request->has('status') ? $request->get('status') : '0';
        if ($tickets_status == '3') {
            $tickets->onlyTrashed();
        } elseif ($tickets_status == '1') {
            $tickets->whereIn('status', [1,4,5]);
        } elseif ($tickets_status == '2') {
            $tickets->where('status', '0');
        } elseif ($tickets_status == '4') {
            $tickets->where('status', '1')->where('is_read', '0');
        } else {
            $tickets->withTrashed();
        }

        $counts = (object)[
            'total' => Ticket::count(),
            'open' => Ticket::whereIn('status', [1,2,3,4,5])->count(),
            'unread' => Ticket::where('is_read', 0)->count(),
            'delete' => Ticket::onlyTrashed()->count(),
        ];

        $tickets = $tickets->latest('updated_at')->paginate();

        return view('backend.pages.tickets.list', compact('tickets', 'tickets_status', 'counts'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TicketRequest $request): RedirectResponse
    {
        $data = $request->validated();

        if (isset($data['attachment'])) {
            $data['attachment'] = $request->attachment->store('attachments', 'public');
        }

        //Заменяем перенос строки
        $data['question'] = str_replace("\r\n", "<br>", $data['question']);

        $ticket = new Ticket;
        $ticket->fill($data);
        $ticket->uuid = Str::uuid();
        $ticket->user()->associate(auth()->user());
        $ticket->save();

        $this->alert('success', __('Вы успешно отправили запрос в поддержку'));

        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Ticket $ticket)
    {
        if ($ticket->user_id === auth()->id() && !$ticket->trashed() || auth()->user()->can('support')) {
            $ticket->load(['user', 'answerer']);
        } else {
            abort(404);
        }

        return view('pages.cabinet.tickets.full', compact('ticket'));
    }

    public function update(TicketUpdateRequest $request, Ticket $ticket)
    {
        if ($request->has('answer')) {

            if (!auth()->user()->isGMAdmin() && $ticket->user_id !== auth()->id()) {
                $this->alert('danger', __('Произошла ошибка! Попробуйте позже.'));
                return back();
            }
            $history = json_decode($ticket->history);

            if ($request->has('attachment') && $request->attachment !== NULL) {
                $attachment = $request->attachment->store('attachments', 'public');
            }

            $history[] = array(
                "text" => str_replace("\r\n", "<br>", $request->input('answer')),
                "attachment" => isset($attachment) ? $attachment : '',
                "user_id" => auth()->user()->id,
                "user_name" => auth()->user()->name,
                "updated_at" => date('d.m.Y H:i'),
                "type" => auth()->user()->isGMAdmin() ? 'answer' : 'question',
            );
            $ticket->history = json_encode($history);

            $ticket->answer = str_replace("\r\n", "<br>", $request->input('answer'));
            $ticket->answerer()->associate(auth()->user());
            $ticket->is_read = 0;
            $ticket->status = 2; //Игрок ответил
            $ticket->save();
        }

        return back();
    }

    public function solve(Ticket $ticket)
    {
        if (!in_array($ticket->status, [4, 5]) && (auth()->user()->can('support') || auth()->id() === $ticket->user_id) ) {
            $ticket->status = 5; //Решено
            $ticket->save();
            $this->alert('success', __('Вы успешно отметили тикет как решенный.'));
        } else {
            $this->alert('danger', __('Вы не можете закрыть этот тикет!'));
        }

        return back();
    }

    public function backend_solve(Ticket $ticket)
    {
        if (!in_array($ticket->status, [4, 5]) && auth()->user()->can('support')) {
            $ticket->status = 5; //Решено
            $ticket->save();
            $this->alert('success', __('Вы успешно отметили тикет как решенный.'));
        } else {
            $this->alert('danger', __('Вы не можете закрыть этот тикет!'));
        }

        return back();
    }

    public function close(Ticket $ticket)
    {
        if (!in_array($ticket->status, [4, 5]) && (auth()->user()->can('support') || auth()->id() === $ticket->user_id) ) {
            $ticket->status = 4; //Закрыто
            $ticket->save();
            $this->alert('success', __('Вы успешно закрыли тикет.'));
        } else {
            $this->alert('danger', __('Вы не можете закрыть этот тикет!'));
        }

        return back();
    }


    public function backend_show(Ticket $ticket)
    {
        $ticket->load(['user', 'answerer']);

        //Заменяем перенос строки
        $ticket->question = str_replace("<br>", "\r\n", $ticket->question);

        return view('backend.pages.tickets.full', compact('ticket'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function backend_update(Request $request, Ticket $ticket)
    {
        if ($request->has('answer')) {

            $history = json_decode($ticket->history);

            if ($request->has('attachment') && $request->attachment !== NULL) {
                $attachment = $request->attachment->store('attachments', 'public');
            }

            $history[] = array(
                "text" => $request->input('answer'),
                "attachment" => isset($attachment) ? $attachment : '',
                "user_id" => auth()->user()->id,
                "user_name" => auth()->user()->name,
                "updated_at" => date('d.m.Y H:i'),
                "type" => 'answer',
            );
            $ticket->history = json_encode($history);
            $ticket->answerer()->associate(auth()->user());
            $ticket->is_read = 1;
            $ticket->status = 3; //Ответ персонала
            $ticket->save();
        }

        return back();
    }

    public function backend_isread(Request $request, Ticket $ticket)
    {
        $ticket->is_read = '1';
        $ticket->save();

        return back();
    }

    public function backend_close(Request $request, Ticket $ticket)
    {
        $ticket->status = 0;
        $ticket->save();

        return back();
    }

    public function backend_update_reply(Request $request, Ticket $ticket)
    {
        if($ticket->history !== NULL) {
            $histories = json_decode($ticket->history);
        }

        $histories_upd = [];
        $index = 0;
        foreach($histories as $history) {
            $index++;
            if ($request->reply_index == $index) {
                $history->text = str_replace("\r\n", "<br>", $request->reply);
            }
            $histories_upd[] = $history;
        }

        $ticket->history = json_encode($histories_upd);
        $ticket->save();

        $this->alert('success', __('Вы успешно обновили сообщение!'));
        return back();
    }

    public function backend_update_question(Request $request, Ticket $ticket)
    {
        //Заменяем перенос строки
        $ticket->question = str_replace("\r\n", "<br>", $request->question);
        $ticket->save();

        $this->alert('success', __('Вы успешно обновили сообщение!'));
        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ticket $ticket)
    {
        $ticket->delete();
        if ($ticket->attachment) {
            Storage::disk('public')->delete($ticket->attachment);
        }

        return back();
    }
}
