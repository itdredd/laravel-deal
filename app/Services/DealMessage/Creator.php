<?php

namespace App\Services\DealMessage;

use App\Events\MessageSent;
use App\Models\Deal;
use App\Models\DealMessage;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class Creator
{
    protected Deal $deal;
    protected User $visitor;
    protected DealMessage $message;

    public function __construct(Deal $deal)
    {
        $this->deal = $deal;
        $this->visitor = Auth::user();
    }

    public function create(string $message)
    {
        $visitor = Auth::user();

        $this->message = new DealMessage();

        $this->message->message = $message;
        $this->message->deal_id = $this->deal->id;
        $this->message->status = 'visible';
    }

    public function setUser(User $user = null) {
        $this->message->user_id = $user->id ?? $this->visitor->id;
    }

    public function save() {
        $this->message->save();
        MessageSent::dispatch('deal', $this->message);

        return $this->message;
    }

}
