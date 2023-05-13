<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class ConversationController extends Controller
{
    public function list()
    {
        $visitor = Auth::user();

        if (!$visitor) {
            return redirect()->route('login');
        }

        return Inertia::render('Conversation/List');
    }

    public function store()
    {
        return Inertia::render('Conversation/Create');
    }
}
