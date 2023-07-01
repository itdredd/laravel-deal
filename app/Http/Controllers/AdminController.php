<?php

namespace App\Http\Controllers;

use App\Models\Deal;
use App\Models\Guarantor;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class AdminController extends Controller
{
    public function list()
    {
        $this->authorize('viewAdminPanel', Auth::user());

        return Inertia::render('Admin/List');
    }

    public function getUsers()
    {
        $this->authorize('viewAdminPanel', Auth::user());

        return response()->json(User::all());
    }

    public function setGuarantor(Request $request)
    {
        $this->authorize('viewAdminPanel', Auth::user());

        if ($request->isMethod('get')) {
            return Inertia::render('Admin/SetGuarantor');
        }

        $user = User::where('name', $request->input('name'))->first();

        if ($user) {
            $user->is_guarantor = 1;
            $user->save();

            Guarantor::create([
                'user_id' => $user->id,
            ]);
        }

        return redirect()->route('guarantors.list');
    }
}
