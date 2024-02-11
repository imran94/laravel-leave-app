<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use function env;

class Leaves extends Model
{
    public $timestamps = false;

    protected $connection = "mysql";
    protected $table = "leaves";
    protected $fillable = ['empId', 'year'];

    public function employee()
    {
        return $this->belongsTo(User::class, 'empId', 'id');
    }

    protected static function booted()
    {
        static::creating(function ($leave) {
            $leave->total = env('TOTAL_LEAVES', 15);
            $leave->annualLeft = env('TOTAL_LEAVES', 15);
            $leave->sickLeft = $leave->employee->designation->department->branch->name === "Malaysia"
                ? env('TOTAL_SICK_LEAVES_MALAYSIA', 14) : env('TOTAL_SICK_LEAVES_PAK', 6);
            $leave->otherLeft = env('TOTAL_OTHER_LEAVES', 6);
        });
    }
}
