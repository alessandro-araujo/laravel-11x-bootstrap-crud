<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserCsv extends Model
{
    // Desabilitar o uso de timestamps
    public $timestamps = false;
    protected $table = 'users_csv';
    protected $fillable = [
        'name',
        'email',
        'password',
    ];
}
