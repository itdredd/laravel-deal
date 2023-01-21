<?php

namespace App\Http\Controllers;

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

        return Inertia::render('Deal/Create');
    }

    public function create(DealPostRequest $request) {
        $deal = new Deal;
        $deal->title = $request->input('title');
        $deal->value = $request->input('value');
        $deal->description = $request->input('description');
        $deal->currency = $request->input('currency');
        $deal->author_id = Auth::user()->id;
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
        else
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
            'members' => $deal->members(),
        ]);

    }
    public function view_edit(Deal $deal) {
        $visitor = Auth::user();

        if ($visitor->id != $deal->author_id && !$visitor->can('editAnyDeal'))
            abort(404);

        return Inertia::render('Deal/Edit', [
            'deal' => $deal,
        ]);
    }

    public function edit(Deal $deal, Request $request) {
        $user = Auth::user();

        if ($user->id != $deal->author_id && !$user->can('editAnyDeal'))
            abort(404);

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

        if($deal->isMember($visitor) && $deal->status === 'awaiting') {
            $deal->status = 'open';
            $deal->save();
        }

        return redirect()->route('deal.view', ['deal' => $deal->id]);
    }
    public function reject(Deal $deal) {
        $visitor = Auth::user();

        if($deal->isMember($visitor) && $deal->status === 'awaiting') {
            $deal->status = 'rejected';
            $deal->save();
        }

        return redirect()->route('deal.list');
    }
}
