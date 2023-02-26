<?php

namespace App\Repository;

use App\Models\Deal;
use App\Models\User;

class DealRepository
{
    public function findForUser(User $user, $status = '')
    {
        if (!$status) {
            $deals = Deal::where([['author_id', $user->id], ['status', '<>', 'rejected']])
                    ->orWhere([
                            ['members_id', $user->id], ['status', '<>', 'rejected']
                    ])->orderByDesc('created_at');;
        } else {
            $deals = Deal::where('status', $status)->where(function ($query) use ($user) {
                $query->where('author_id', $user->id)
                        ->orWhere('members_id', $user->id)->orderByDesc('created_at');
            });
        }
        return $deals->get();
    }
    public function all()
    {
        return Deal::all();
    }

}
