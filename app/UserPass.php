<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserPass extends Model {

    protected $table = "user_pass";

    public function user() {
        return $this->belongsTo('App\User', 'prefix_id', 'prefix_id');
    }

}
