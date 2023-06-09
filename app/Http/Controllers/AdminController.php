<?php

namespace App\Http\Controllers;

use App\Models\Deal;
use App\Models\Guarantor;
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

    public function setGuarantor(Request $request)
    {
        $this->authorize('viewAdminPanel', Auth::user());

        $user = User::where('name', $request->input('name'))->get();

        if ($user) {
            Guarantor::create([
                'user_id' => $user->id,
            ]);
        }

        return redirect()->route('guarantors');
    }
}
