<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HiringPlanItemEvents extends Model
{
    protected $fillable = ['hiring_plan_item_id', 'event', 'created_by'];
    public function hiringPlanItem()
    {
        return $this->belongsTo(HiringPlanItem::class, 'hiring_plan_item_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
    public function getLabelAttribute(): string
    {
        return 'Event: ' . $this->event . ' (on ' . $this->created_at . ')';
    }

}
