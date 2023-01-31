<?php

namespace App\Services\Message;

use App\Models\Deal;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;

class Deleter
{
    protected Deal $deal;
    protected Message $message;

    public function __construct(Message $message)
    {
        $this->message = $message;
        $this->deal = $message->deal;
    }

    public function delete() {
        $this->message->delete();
    }

}
