<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Verfication extends Model
{
    use HasFactory;

    const TYPE = ['activate', 'reset'];

    protected $fillable = [
        'phone',
        'code',
        'type',
        'expired_at',
        'user_type',    // [user | provider] , default is > user
    ];
}
