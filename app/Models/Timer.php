<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Timer extends Model
{
    protected $fillable = [
        'duration',
        'started',
    ];

    protected $casts = [
        'started' => 'boolean',
    ];
}
