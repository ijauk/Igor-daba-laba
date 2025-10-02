<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HiringPlan extends Model
{
    protected $fillable = ['title', 'valid_from', 'valid_to', 'description', 'active'];
    protected $casts = [
        'valid_from' => 'date',
        'valid_to' => 'date',
        'active' => 'boolean',
    ];

    public function jobPositions()
    {
        return $this->hasMany(JobPosition::class, 'hiring_plan_id');
    }
    public function items()
    {
        return $this->hasMany(HiringPlanItem::class, 'hiring_plan_id');
    }
    public function getLabelAttribute(): string
    {
        return 'Hiring Plan from ' . $this->valid_from . ' to ' . $this->valid_to;
    }
    
}
