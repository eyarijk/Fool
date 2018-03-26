<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StartGame extends Model
{
    public function deck()
    {
        return $this->hasMany('App\Deck');
    }

    public function move()
    {
        return $this->hasMany('App\Move');
    }

    public function player()
    {
        return $this->hasMany('App\Player');
    }
}
