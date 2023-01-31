<?php

namespace App\Http\Controllers;

use App\Http\Requests\DealPostRequest;
use App\Models\Deal;
use App\Models\User;
use App\Repository\DealRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class DealController extends Controller
{
    protected DealRepository $dealRepo;

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

        $creatorService = new \App\Services\Deal\Creator();

        $deal = $creatorService->create($request->input());
        $deal->save();

        return redirect()->route('deal.view', ['deal' => $deal->id]);
    }

    public function list(Request $request) {
        $visitor = Auth::user();

        if (!$visitor)
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

        $creatorService = new \App\Services\Message\Creator($deal); // TODO another way?

        $message = $creatorService->create($request->input('message'));
        $message->save();
    }
}
