<?php

namespace App\Repository;

use App\Models\Deal;
use App\Models\Message;
use App\Models\User;

class MessageRepository
{
    public function getMessageFromDeal(Deal $deal, User $user) {
        $messages = Message::where('deal_id', $deal->id)->get();

        return $messages;
    }




}
