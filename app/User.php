<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{

    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'username',
        'password',
        'access_type',
        'is_change_pass',
        'prefix_id',
        'designationId',
        'email',
        'tlId',
        'departmentId'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function hasPrefix()
    {
        return $this->hasOne('App\UserPass', 'prefix_id', 'prefix_id');
    }

    public function designation()
    {
        return $this->belongsTo(Designation::class, 'designationId', 'id');
    }

    public function leaveRequests()
    {
        return $this->hasMany(LeaveRequest::class, 'empId', 'id');
    }
}
