<?php

namespace App\Repository\Review;

use App\Models\GuarantorReview;

class ReviewRepository
{
    public function createReview(int $userId, float $rating, int $guarantorId, string $review)
    {
        GuarantorReview::create([
            'user_id' => $userId,
            'rating' => $rating,
            'guarantor_id' => $guarantorId,
            'review' => $review
        ]);
    }
}
