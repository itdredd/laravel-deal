<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Collection;

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

    /**
     * @return Collection
     */
    public function members() {
        return User::whereIn('id', explode(", ", $this->members_id))->get();
    }

    public function isMember(User $user) {
        return $this->members()->contains($user);
    }


    protected function price() : Attribute {
        return Attribute::make(
            get: fn ($value, $attributes) => $attributes['value'] . ' ' . $attributes['currency'],
        );
    }

    public function canView(User $user) {
        return $user->isAdmin() || $this->author() !== $user || !in_array($user, $this->members());
    }
}


