<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
/**
 * @property \Illuminate\Support\Carbon|null $posted_at
 * @property \Illuminate\Support\Carbon|null $expires_at
 * @property \Illuminate\Support\Carbon|null $deadline
 */
class JobPosting extends Model
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
    public function candidates()
    {
        return $this->belongsToMany(Candidate::class, 'candidate_postings', 'posting_id', 'candidate_id');
    }
    protected $casts = [
        'posted_at' => 'datetime',
        'deadline' => 'datetime',
        'expires_at' => 'date',
    ];
}
