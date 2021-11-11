<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    //
    protected $fillable = [
        'number', 'couier', 'address', 'owner', 'port'
    ];
}
