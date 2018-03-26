<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Move extends Model
{
    public function game()
    {
        return $this->belongsTo('App\StartGame');
    }

    public function player()
    {
        return $this->belongsTo('App\User','player_id');
    }

}
