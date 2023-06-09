<?php

namespace App\Http\Controllers;

use App\Http\Resources\GuarantorResource;
use App\Models\Guarantor;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class GuarantorController extends Controller
{

    public function find(Request $request)
    {
        $users = User::where('is_guarantor', 1);

        if ($request->input('name')) {
            $users->where('name', 'LIKE', $request->input('name'));
        }

        return response()->json(GuarantorResource::collection($users->get()));
    }

    public function list()
    {
        $guarantors = Guarantor::all();

        return Inertia::render('Guarantors/List', [
            'guarantors' => $guarantors
        ]);
    }
}
