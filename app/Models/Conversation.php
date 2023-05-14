<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $title
 * @property int $user_id
 * @property int $created_at
 * @property int $updated_at
 */
class Conversation extends Model
{
    use HasFactory;

    protected $fillable = [
            'title',
            'user_id',
            'created_at',
            'updated_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function messages()
    {
        return $this->hasMany(ConversationMessage::class);
    }

    public function conversationMembers()
    {
        return $this->hasMany(ConversationMember::class);
    }

    public function members()
    {
        $convMembers = $this->conversationMembers()->get();

        foreach ($convMembers as $convMember) {
            $members[] = $convMember->user;
        }

        return $members;
    }
}
