<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    public function game()
    {
        return $this->belongsTo('StartGame');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}

