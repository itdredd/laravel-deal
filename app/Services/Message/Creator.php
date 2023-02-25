<?php

namespace App\Services\Message;

use App\Models\Deal;
use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class Creator
{
    protected Deal $deal;
    protected User $visitor;
    protected Message $message;

    public function __construct(Deal $deal)
    {
        $this->deal = $deal;
        $this->visitor = Auth::user();
    }

    public function create(string $message)
    {
        $visitor = Auth::user();

        $this->message = new Message();

        $this->message->message = $message;
        $this->message->deal_id = $this->deal->id;
        $this->message->status = 'visible';

        return $this->message;
    }

    public function setUser(User $user = null) {
        $this->message->user_id = $user->id ?? $this->visitor->id;
    }

}
