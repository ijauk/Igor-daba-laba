<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job_position extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'description', 'min_salary', 'max_salary', 'is_active', 'education_id'];
    public function jobPostings()
    {
        return $this->hasMany(Job_posting::class, 'job_position_id');
    }
}
