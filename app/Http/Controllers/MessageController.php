<?php

namespace App\Http\Controllers;

use App\Models\Deal;
use App\Repository\MessageRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    private MessageRepository $messageRepo;
    public function __construct(MessageRepository $messageRepo)
    {
        $this->messageRepo = $messageRepo;
    }

    public function getDealMessages(Request $request, Deal $deal) {
        $this->authorize('view', $deal);

        if ($request->query('type') === 'json') {
            $visitor = Auth::user();

            $message = $this->messageRepo->getMessageFromDeal($deal, $visitor);
            return response()->json($message);
        }
    }
}
