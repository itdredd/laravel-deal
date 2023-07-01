<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


/**
 * @property int $id
 * @property int $user_id
 * @property float $rating
 * @property int $guarantor_id
 * @property string $review
 * @property int $created_at
 * @property int $updated_at
 */
class GuarantorReview extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'rating', 'guarantor_id', 'review'];
}
