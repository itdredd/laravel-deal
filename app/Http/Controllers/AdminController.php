<?php

namespace App\Http\Controllers;

use App\Models\Deal;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function getUsers()
    {
        $this->authorize('viewAdminPanel', Auth::user());

        return response()->json(User::all());
    }
}
