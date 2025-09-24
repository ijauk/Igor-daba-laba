<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HiringPlan extends Model
{
    protected $fillable = ['valid_from', 'valid_to', 'description', 'active'];
    public function jobPositions()
    {
        return $this->hasMany(JobPosition::class, 'hiring_plan_id');
    }
}
