<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $with = ['user'];

    public function user() {
        return $this->belongsTo(User::class);
    }
    public function deal() {
        return $this->belongsTo(Deal::class);
    }
}
