<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Match extends Model
{
    public function moves() {
        return $this->hasMany('App\Move', 'match_id');
    }
}
