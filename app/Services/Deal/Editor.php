<?php

namespace App\Services\Deal;

use App\Models\Deal;
use App\Models\DealMember;
use App\Models\User;

class Editor
{
    public $deal;

    public function __construct(Deal $deal)
    {
        $this->deal = $deal;
    }

    public function setGuarantor(User $user)
    {
        if ($user->is_guarantor) {
            $this->deal->guarantor_id = $user->id;
            $this->deal->save();

            DealMember::create([
                'user_id' => $user->id,
                'deal_id' => $this->deal->id
            ]);
        }
    }
}
