<?php

namespace App\Repository;

use App\Models\Deal;
use App\Models\DealMember;
use App\Models\User;

class DealRepository
{
    public function findForUser(User $user, $status = '')
    {
        if (!$status) {
            $dealsId = DealMember::where('user_id', $user->id)->pluck('deal_id');
            $deals = Deal::whereIn('id', $dealsId)
                    ->where('status', '<>', 'rejected')
                    ->orderByDesc('created_at');
        } else {
            $dealsId = DealMember::where('user_id', $user->id)->pluck('deal_id');
            $deals = Deal::whereIn('id', $dealsId)
                    ->where('status', $status)
                    ->orderByDesc('created_at');
        }
        return $deals->get();
    }
}
