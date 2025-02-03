<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sessions extends Model
{
    protected $fillable = [
        'user_id',
        'ip_address',
        'user_agent',
    ];
}
