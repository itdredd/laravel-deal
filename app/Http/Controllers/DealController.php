<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Policies\DealPolicy;
use App\Repository\DealRepository;
use App\Http\Requests\DealPostRequest;
use App\Models\Deal;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Illuminate\Support\Facades\Gate;

class DealController extends Controller
{
    private DealRepository $dealRepo;

    public function __construct(DealRepository $dealRepo) {
        $this->dealRepo = $dealRepo;
    }

    public function store(Request $request) {
        $visitor = Auth::user();

        $this->authorize('create', Deal::class);

        return Inertia::render('Deal/Create');
    }

    public function create(DealPostRequest $request) {
        $visitor = Auth::user();

        $this->authorize('create', Deal::class);

        $deal = new Deal;
        $deal->title = $request->input('title');
        $deal->value = $request->input('value');
        $deal->description = $request->input('description');
        $deal->currency = $request->input('currency');
        $deal->author_id = $visitor->id;
        $deal->status = 'awaiting';

        $users = explode(',', $request->input('members_id'));
        foreach($users as $key=>$user) {
            $user = User::where('name', $user);
            if(!$user || !$user->exists())
                abort(404);
            else {
                if(!$deal->members_id)
                    $deal->members_id = $user->first()->id;
                else
                    $deal->members_id = $deal->members_id . ", " . $user->first()->id;
            }

        }

        $deal->save();

        return redirect()->route('deal.view', ['deal' => $deal->id]);
    }

    public function list(Request $request) {
        $visitor = Auth::user();

        if(!$visitor)
            return redirect()->route('login');

        $deals = $this->dealRepo->findForUser($visitor, $request->input('status'));

        if ($request->query('type') == 'json')
            return json_encode($deals);

        return Inertia::render('Deal/List', [
                'deals' => $deals,
            ]);
    }

    public function view(Deal $deal) {
        $visitor = Auth::user();

        $this->authorize('view', $deal);

        return Inertia::render('Deal/View', [
            'deal' => $deal,
            'visitor' => $visitor,
            'messages' => $deal->messages,
            'members' => $deal->members(),
        ]);

    }
    public function view_edit(Deal $deal) {
        $visitor = Auth::user();

        $this->authorize('update', $deal);

        return Inertia::render('Deal/Edit', [
            'deal' => $deal,
        ]);
    }

    public function edit(Deal $deal, Request $request) {
        $user = Auth::user();

        $this->authorize('update', $deal);

        $deal->status = $request->input('status');
        $deal->title = $request->input('title');
        $deal->value = $request->input('value');
        $deal->description = $request->input('description');
        $deal->members_id = $request->input('members_id');
        $deal->save();

        return redirect()->route('deal.view', ['deal' => $deal->id]);
    }

    public function approve(Deal $deal) {
        $visitor = Auth::user();

        $this->authorize('approve', $deal);

        $deal->status = 'open';
        $deal->save();

        return redirect()->route('deal.view', ['deal' => $deal]);
    }
    public function reject(Deal $deal) {
        $visitor = Auth::user();

        $this->authorize('reject', $deal);

        $deal->status = 'rejected';
        $deal->save();

        return redirect()->route('deal.list');
    }
    public function postReply(Deal $deal, Request $request) {
        $visitor = Auth::user();

        $this->authorize('postReply', $deal);

        $message = new Message();
        $message->deal_id = $deal->id;
        $message->user_id = $visitor->id;
        $message->status = 'visible';
        $message->message = $request->input('message');

        $message->save();

        return redirect()->route('deal.view', ['deal' => $deal]);


/*        $table->unsignedInteger('deal_id');
        $table->unsignedInteger('user_id');
        $table->longText('message');
        $table->enum('status', ['visible', 'deleted']);;*/
    }
}
