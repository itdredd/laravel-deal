<?php

namespace App\Http\Controllers;

use App\Models\Deal;
use App\Models\Message;
use App\Repository\MessageRepository;
use App\Services\Message\Deleter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class MessageController extends Controller
{
    private MessageRepository $messageRepo;
    public function __construct(MessageRepository $messageRepo)
    {
        $this->messageRepo = $messageRepo;
    }

    public function getDealMessages(Request $request, Deal $deal)
    {
        $this->authorize('view', $deal);

        if ($request->ajax()) {
            $visitor = Auth::user();

            $message = $this->messageRepo->getMessageFromDeal($deal, $visitor);
            return response()->json($message);
        }
    }

    public function remove(Message $message)
    {
        $deal = $message->deal;

        $delService = new Deleter($message);
        $delService->delete();

        return redirect()->route('deal.view', ['deal' => $deal]);
    }

    public function viewEdit(Message $message)
    {
        return Inertia::render('Message/Edit', [
                'message' => $message,
        ]);
    }

    public function edit(Message $message, Request $request)
    {
        $newMessage = $request->input('message');

        if ($newMessage) {
            $message->message = $newMessage;
            $message->save();
        }

        return redirect()->route('deal.view', ['deal' => $message->deal]);
    }
}


