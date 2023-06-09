<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;
use LaravelAndVueJS\Traits\LaravelPermissionToVueJS;

/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property int $email_verified_at
 * @property string $password
 * @property $remember_token
 * @property string $created_at
 * @property string $updated_at
 * @property string $avatar
 * @property int $is_admin
 * @property int $is_guarantor
 * @property string $language
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'language'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function messages() {
        return $this->hasMany(DealMessage::class);
    }

    public function deals()
    {
        return $this->hasMany(Deal::class, 'author_id');
    }

    public function guarantorDeals()
    {
        return $this->hasMany(Deal::class, 'guarantor_id');
    }

    public function conversationsMember()
    {
        return $this->hasMany(ConversationMember::class)->orderBy('id', 'DESC');
    }

    public function getAvatarUrl() {
        return $this->avatar ? '/storage/avatars/' . $this->avatar : 'https://png.pngtree.com/png-clipart/20210129/ourmid/pngtree-default-male-avatar-png-image_2811083.jpg';
    }

}
