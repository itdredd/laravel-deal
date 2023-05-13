<?php

namespace App\Repository;

use App\Models\Deal;
use App\Models\DealMessage;
use App\Models\User;

class MessageRepository
{
    public function getMessageFromDeal(Deal $deal, User $user) {
        $messages = DealMessage::where('deal_id', $deal->id)->get();

        return $messages;
    }

}
