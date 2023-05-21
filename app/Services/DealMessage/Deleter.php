<?php

namespace App\Services\DealMessage;

use App\Models\Deal;
use App\Models\DealMessage;
use Illuminate\Support\Facades\Auth;

class Deleter
{
    protected Deal $deal;
    protected DealMessage $message;

    public function __construct(DealMessage $message)
    {
        $this->message = $message;
        $this->deal = $message->deal;
    }

    public function delete() {
        $this->message->delete();
    }

}
