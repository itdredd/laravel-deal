<?php

namespace App\Repository;

use App\Models\Deal;
use Symfony\Component\HttpFoundation\Request;
use App\Models\User;

class DealRepository
{
    private Deal $deal;

    public function __construct(Deal $deal) {
        $this->deal = $deal;
    }


    /*if (!$request->query('status'))
    $deals = Deal::where('author_id', Auth::user()->id)->orWhere('members_id', Auth::user()->id);
else
    $deals = Deal::where('status', $request->input('status'))->where(function ($query) {
        $query->where('author_id', Auth::user()->id)
            ->orWhere('members_id', Auth::user()->id);
    });

$deals = $deals->get();*/
    public function findForUser(User $user, $status = '') {

        if($user->isAdmin())
            return Deal::all();
        else if(!$status)
            $deals = Deal::where([['author_id', $user->id], ['status', '<>', 'rejected']])->orWhere([['members_id', $user->id], ['status', '<>', 'rejected']]);
        else
            $deals = Deal::where('status', $status)->where(function ($query) use ($user) {
                $query->where('author_id', $user->id)
                    ->orWhere('members_id', $user->id);
            });

        return $deals->get();

    }

    public function all() {
        return Deal::all();
    }



}
