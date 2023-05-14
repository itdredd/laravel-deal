<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $conversation_id
 * @property int $user_id
 * @property int $last_read
 * @property int $created_at
 * @property int $updated_at
 */
class ConversationMember extends Model
{
    use HasFactory;

    protected $fillable = ['conversation_id' , 'user_id', 'last_read'];
}
