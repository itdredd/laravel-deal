<?php

namespace App\Http\Controllers;

use App\Http\Resources\GuarantorResource;
use App\Models\User;
use Illuminate\Http\Request;

class GuarantorController extends Controller
{

    public function find(Request $request) {
        $users = GuarantorResource::collection(User::where('is_guarantor', 1)->get());
        return response()->json($users);
    }
}
