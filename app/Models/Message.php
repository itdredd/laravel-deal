<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $created_at
 * @property int $updated_at
 * @property int $deal_id
 * @property int $user_id
 * @property string $message
 * @property string $status
 */
class Message extends Model
{
    use HasFactory;

    protected $with = ['user', 'messageHistory'];

    public function messageHistory(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(MessageHistory::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo|User
     */
    public function user() {
        return $this->belongsTo(User::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo|Deal
     */
    public function deal() {
        return $this->belongsTo(Deal::class);
    }
}
