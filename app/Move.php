<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Move extends Model
{
    public function match() {
        return $this->belongsTo('App\Match', 'match_id');
    }
}
