<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobPosition extends Model
{
    protected $fillable = ['name', 'description', 'min_salary', 'max_salary', 'is_active '];
    public function jobPostings()
    {
        return $this->hasMany(Job_posting::class, 'job_position_id');
    }
}
