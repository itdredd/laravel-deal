<?php

namespace App\Services\Message;

use App\Models\Deal;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;

class Editor
{
    protected Deal $deal;
    protected Message $message;

    public function __construct(Message $message)
    {
        $this->message = $message;
        $this->deal = $message->deal;
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
