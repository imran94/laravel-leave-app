<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LeaveRequest extends Model
{
    protected $connection = "mysql";
    protected $table = "leave_requests";
    protected $fillable = [
        'empId',
        'name',
        'leaveDate',
        'return_date',
        'time_period',
        'leaves',
        'reason',
        'status',
        'type',
        'lineManagerId',
        'attachment'
    ];

    public function employee()
    {
        return $this->belongsTo(User::class, 'empId', 'id');
    }
}
