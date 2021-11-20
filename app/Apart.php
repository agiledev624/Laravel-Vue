<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Apart extends Model
{
    //
    protected $fillable = [
        'number', 'phone', 'pin',
    ];

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
}
