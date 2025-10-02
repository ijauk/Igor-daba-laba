<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HiringPlanItem extends Model
{
    protected $fillable = ['hiring_plan_id', 'job_position_id', 'snap_name', 'snap_organizational_unit_id', 'snap_education_id', 'snap_coefficient'];   
    public function hiringPlan()
    {
        return $this->belongsTo(HiringPlan::class, 'hiring_plan_id');
    }
    public function jobPosition()
    {
        return $this->belongsTo(JobPosition::class, 'job_position_id');
    }
    public function notes()
    {
        return $this->hasMany(HiringPlanItemNote::class, 'hiring_plan_item_id');
    }
    public function events()
    {
        return $this->hasMany(HiringPlanItemEvents::class, 'hiring_plan_item_id');
    }   

    public function getLabelAttribute(): string
    {
        return $this->name . ' (' . ($this->jobPosition ? $this->jobPosition->code : 'N/A') . ')';
    }
}
