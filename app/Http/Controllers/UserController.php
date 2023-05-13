<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UserController extends Controller
{
    public function findUser(Request $request)
    {
        // TODO minimal length request name
        $users = User::select('id', 'name')->where('name', 'LIKE', $request->input('name') . '%')->get();
        return $users;
    }
}
