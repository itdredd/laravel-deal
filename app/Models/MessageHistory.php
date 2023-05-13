<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $message_id
 * @property string $old_message
 * @property string $new_message
 * @property int $user_id
 * @property int $created_at
 * @property int $updated_at
 */
class MessageHistory extends Model
{
    use HasFactory;

    protected $fillable = [
            'message_id',
            'old_message',
            'new_message',
            'user_id'
    ];

    public function message() {
        return $this->belongsTo(DealMessage::class);
    }
}
