<?php

namespace App\Http\Controllers;

use App\Repository\DealRepository;
use App\Http\Requests\DealPostRequest;
use App\Models\Deal;
use App\Models\User;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;

class DealController extends Controller
{


    public function store(Request $request) {

        return Inertia::render('Deal/Create');
    }

    public function create(DealPostRequest $request) {
        if (!User::where('id', $request->input('members_id'))->exists())
            return 200; // TODO error
        $deal = new Deal;
        $deal->title = $request->input('title');
        $deal->value = $request->input('value');
        $deal->description = $request->input('description');
        $deal->currency = $request->input('currency');
        $deal->members_id = $request->input('members_id');
        $deal->author_id = Auth::user()->id;
        $deal->status = 'awaiting';
        $deal->save();

        return redirect()->route('deal.list');
    }

    public function list(Request $request) {

        if (!$request->query('status'))
            $deals = Deal::where('author_id', Auth::user()->id)->orWhere('members_id', Auth::user()->id);
        else
            $deals = Deal::where('status', $request->input('status'))->where(function ($query) {
                $query->where('author_id', Auth::user()->id)
                    ->orWhere('members_id', Auth::user()->id);
            });

        $deals = $deals->get();

        if ($request->query('type') == 'json')
            return json_encode($deals);
        else
            return Inertia::render('Deal/List', [
                'deals' => $deals,
            ]);

    }

    public function view(Deal $deal) {
        if (Auth::user()->cannot('view', $deal))
            abort(404);

        return Inertia::render('Deal/View', [
            'deal' => $deal,
            'user' => Auth::user(),
        ]);

    }

    public function view_edit(Deal $deal) {
        $user = Auth::user();

        if ($user->id != $deal->author_id && !$user->can('editAnyDeal'))
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


}
