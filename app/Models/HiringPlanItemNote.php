<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HiringPlanItemNote extends Model
{
    protected $fillable = ['hiring_plan_item_id', 'note', 'created_by'];
    public function hiringPlanItem()
    {
        return $this->belongsTo(HiringPlanItem::class, 'hiring_plan_item_id');
    }
}
