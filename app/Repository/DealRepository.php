<?php

namespace App\Repository;

use App\Models\Deal;
use App\Models\User;

class DealRepository
{
    public function findForUser(User $user, $status = '')
    {
        if (!$status) {
            $deals = Deal::where('status', '<>', 'rejected')
                    ->where(function ($query) use ($user) {
                        $query->where('author_id', $user->id)
                                ->orWhere('members_id', $user->id)
                                ->orWhere('guarantor_id', $user->id);
                    })->orderByDesc('created_at');
        } else {
            $deals = Deal::where('status', $status)
                    ->where(function ($query) use ($user) {
                        $query->where('author_id', $user->id)
                                ->orWhere('members_id', $user->id)
                                ->orWhere('guarantor_id', $user->id);
            })->orderByDesc('created_at');
        }
        return $deals->get();
    }
}
