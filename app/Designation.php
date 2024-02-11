<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Designation extends Model
{
    protected $table = "designation";

    protected $fillable = [
        'deptId'
    ];

    public function department()
    {
        return $this->belongsTo(Department::class, 'deptId', 'id');
    }

    public function users()
    {
        return $this->hasMany(User::class, 'designationId', 'id');
    }
}
