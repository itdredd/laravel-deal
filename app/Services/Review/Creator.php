<?php

namespace App\Services\Review;

use App\Http\Requests\Review\CreateRequest;
use App\Models\GuarantorReview;
use App\Repository\Review\ReviewRepository;

class Creator
{
    public function createReviews(CreateRequest $request)
    {
        $userId = $request->input('user_id');
        $rating = $request->input('rating');
        $guarantorId = $request->input('guarantor_id');
        $review = $request->input('review');

        $this->repository()->createReview($userId, $rating, $guarantorId, $review);
    }


    private function repository()
    {
        return new ReviewRepository();
    }
}
