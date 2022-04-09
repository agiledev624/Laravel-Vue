<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Courier extends Model
{
    //
    protected $fillable = [
        'user_id', 'name', 'password'
    ];
}
