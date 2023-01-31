<?php

namespace App\Services\Message;

use App\Models\Deal;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;

class Creator
{
    protected Deal $deal;

    public function __construct(Deal $deal)
    {
        $this->deal = $deal;
    }

    public function create(string $message)
    {
        $visitor = Auth::user();

        $message = new Message();
        $message->user_id = $visitor->id;
        $message->message = $message;
        $message->deal_id = $this->deal->id;
        $message->status = 'visible';

        return $message;
    }

}
