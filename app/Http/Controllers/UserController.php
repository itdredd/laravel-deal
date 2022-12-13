<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function findUser(Request $request) {
        $users = User::select('id', 'name')->where('name', 'LIKE', $request->input('name'))->get();
        return $users;
    }
}
