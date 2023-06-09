<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $user_id
 * @property float $rating
 * @property int $successful_deals
 * @property int $dissatisfied_deals
 * @property int $created_at
 * @property int $updated_at
 */
class Guarantor extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
