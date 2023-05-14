<?php

namespace App\Services\Conversation;

use App\Models\Conversation;
use App\Models\ConversationMember;
use App\Models\ConversationMessage;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class Creator
{
    public static function createConversation($title, $message, $members)
    {
        $id = Auth::id();

        $conversation = Conversation::create([
                'title' => $title,
                'user_id' => $id
        ]);

        $conversationMessage = ConversationMessage::create([
                'user_id' => $id,
                'conversation_id' => $conversation->id,
                'message' => $message
        ]);

        ConversationMember::create([
                'conversation_id' => $conversation->id,
                'user_id' => $id
        ]);

        $users = User::whereIn('name', explode(", ", $members))->get();
        foreach ($users as $user) {
            ConversationMember::create([
                    'conversation_id' => $conversation->id,
                    'user_id' => $user->id
            ]);
        }
    }

}
