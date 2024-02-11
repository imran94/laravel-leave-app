<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    protected $table = "branch";

    public function departments()
    {
        return $this->hasMany(Department::class, 'branch_id', 'id');
    }
}
