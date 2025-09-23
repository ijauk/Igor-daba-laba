<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobPosition extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'description', 'min_salary', 'max_salary', 'is_active', 'education_id'];
    public function jobPostings()
    {
        return $this->hasMany(JobPosting::class, 'job_position_id');
    }
    public function organizationalUnit()
    {
        return $this->hasOne(OrganizationalUnit::class, 'id', 'organizational_unit_id');
    }
}
