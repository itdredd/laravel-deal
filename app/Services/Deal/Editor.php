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

    public function setGuarantor($user)
    {
        if ($user instanceof User) {
            $user = $user->id;
        }

        $this->deal->guarantor_id = $user;
        $this->deal->save();

        DealMember::create([
                'user_id' => $user,
                'deal_id' => $this->deal->id
        ]);
    }
}