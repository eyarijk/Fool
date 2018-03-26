<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Deck extends Model
{
    public function game()
    {
        return $this->belongsTo('App\StartGame');
    }
}
