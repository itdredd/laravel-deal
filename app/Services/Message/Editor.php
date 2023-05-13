<?php

namespace App\Services\Message;

use App\Models\DealMessage;
use App\Models\MessageHistory;
use Illuminate\Support\Facades\Auth;

class Editor
{

    protected DealMessage $message;
    protected $oldMessage;
    protected $newMessage;

    public function __construct(DealMessage $message, $newMessage)
    {
        $this->message = $message;
        $this->oldMessage = $message->message;
        $this->newMessage = $newMessage;

        $this->createHistory();
        $message->message = $newMessage;
        $message->save();
    }

    protected function createHistory()
    {
        $history = MessageHistory::create([
            'message_id' => $this->message->id,
            'old_message' => $this->oldMessage,
            'new_message' => $this->newMessage,
            'user_id' => Auth::id()
        ]);
    }
}
