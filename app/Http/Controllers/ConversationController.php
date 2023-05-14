<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Services\Conversation\Creator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class ConversationController extends Controller
{
    public function list(Request $request)
    {
        $visitor = Auth::user();
        $conversations = [];

        if (!$visitor) {
            return redirect()->route('login');
        }

        foreach ($visitor->conversationsMember()->paginate(20) as $conversationMember) {
            $conversations[] = $conversationMember->conversation;
        }

        if ($request->ajax()) {
            return response()->json($conversations);
        }

        return Inertia::render('Conversation/List', [
                'conversations' => $conversations
        ]);
    }

    public function store()
    {
        return Inertia::render('Conversation/Create');
    }

    public function create(Request $request)
    {
        Creator::createConversation($request->input('title'), $request->input('message'), $request->input('members_id'));

        return Redirect::route('conv.list');
    }

    public function message(Conversation $conversation, Request $request)
    {
        $this->authorize('view', $conversation);

        return response()->json($conversation->messages);
    }
}
