<?php

namespace App\Http\Controllers;

use App\Http\Requests\Review\CreateRequest;
use App\Services\Review\Creator;
use Illuminate\Http\Request;

class GuarantorReviewController extends Controller
{
    public function create(CreateRequest $request)
    {
        $service = new Creator();
        $service->createReviews($request);

        return ['success' => 'true'];
    }
}
