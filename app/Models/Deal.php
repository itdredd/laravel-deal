<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Collection;

/**
 * @property int $id
 * @property string $title
 * @property string $description
 * @property int $author_id
 * @property int $value
 * @property string $currency
 * @property int $created_at
 * @property int $updated_at
 * @property string $status
 * @property int $balance
 * @property int $guarantor_id
 */
class Deal extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'description',
        'author_id',
        'value',
        'currency',
        'status',
        'balance',
        'guarantor_id'
    ];

    protected $with = ['author', 'guarantor', 'members'];

    public function author() {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function messages() {
        return $this->hasMany(DealMessage::class);
    }

    public function guarantor() {
        return $this->belongsTo(User::class);
    }

    public function members()
    {
        return $this->hasMany(DealMember::class)->orderBy('created_at');
    }

    public function isMember($user)
    {
        foreach ($this->members as $member) {
            if ($member->user->id === $user->id) {
                return true;
            }
        }
    }

}


