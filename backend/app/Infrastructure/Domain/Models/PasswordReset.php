<?php

namespace App\Infrastructure\Domain\Models;

use Illuminate\Database\Eloquent\Model;

class PasswordReset extends Model
{
    protected $fillable = [
        'phone',
        'token',
        'created_at',
        'type',
        'country_code'
    ];

    public $timestamps = false;

    protected $primaryKey = 'phone';
}
