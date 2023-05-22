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
 * @property string $members_id
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
        'members_id',
        'status',
        'balance',
        'guarantor_id'
    ];

    protected $with = ['author', 'guarantor'];

    public function status() {
        return $this->status;
    }
    public function author() {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function messages() {
        return $this->hasMany(DealMessage::class);
    }

    public function guarantor() {
        return $this->belongsTo(User::class);
    }

    // TODO edit to relationship
    /**
     * @return Collection
     */
    public function members() {
        return User::whereIn('id', explode(", ", $this->members_id))->get();
    }

    public function isMember(User $user) {
        return $this->members()->contains($user);
    }

    public function isOpen() {
        return $this->status === 'open';
    }

    protected function price() : Attribute {
        return Attribute::make(
            get: fn ($value, $attributes) => $attributes['value'] . ' ' . $attributes['currency'],
        );
    }

}


