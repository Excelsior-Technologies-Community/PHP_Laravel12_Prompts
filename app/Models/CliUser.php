<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CliUser extends Model
{
    protected $fillable = [
        'email',
        'password',
    ];
}