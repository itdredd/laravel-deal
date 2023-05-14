<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $user_id
 * @property string $message
 * @property int $conversation_id
 * @property int $created_at
 * @property int $updated_at
 */
class ConversationMessage extends Model
{
    use HasFactory;

    protected $fillable = [
            'message',
            'user_id',
            'conversation_id',
            'created_at',
            'updated_at',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
