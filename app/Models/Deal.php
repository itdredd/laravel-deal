<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Deal extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'author_id',
        'value',
        'currency',
        'members_id',
    ];

    protected $with = ['author'];

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function members() {
        return User::whereIn('id', explode(", ", $this->members_id))->get();
    }

    public function isMember(User $user) {
        return isset($this->members_id, $user->id);
    }


    protected function price() : Attribute {
        return Attribute::make(
            get: fn ($value, $attributes) => $attributes['value'] . ' ' . $attributes['currency'],
        );
    }
}


