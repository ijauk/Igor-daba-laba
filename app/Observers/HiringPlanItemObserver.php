<?php

namespace App\Observers;

use App\Models\HiringPlanItem;

class HiringPlanItemObserver
{
    /**
     * Handle the HiringPlanItem "created" event.
     */
    public function created(HiringPlanItem $hiringPlanItem): void
    {
        $p = $hiringPlanItem->jobPosition()->firstOrFail();
        $hiringPlanItem->snap_name = $p->name;
        $hiringPlanItem->snap_organizational_unit_id = $p->organizational_unit_id;
        $hiringPlanItem->snap_education_id = $p->education_id;
        $hiringPlanItem->snap_coefficient = $p->planned_coefficient;
    }

    /**
     * Handle the HiringPlanItem "updated" event.
     */
    public function updated(HiringPlanItem $hiringPlanItem): void
    {
        //
    }

    /**
     * Handle the HiringPlanItem "deleted" event.
     */
    public function deleted(HiringPlanItem $hiringPlanItem): void
    {
        //
    }

    /**
     * Handle the HiringPlanItem "restored" event.
     */
    public function restored(HiringPlanItem $hiringPlanItem): void
    {
        //
    }

    /**
     * Handle the HiringPlanItem "force deleted" event.
     */
    public function forceDeleted(HiringPlanItem $hiringPlanItem): void
    {
        //
    }
}
