<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Job_posting extends Model
{
    protected $fillable = ['title', 'description', 'posted_at', 'expires_at', 'deadline', 'is_valid', 'employee_id', 'job_position_id'];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
    public function jobPosition()
    {
        return $this->belongsTo(JobPosition::class, 'job_position_id');
    }
}
