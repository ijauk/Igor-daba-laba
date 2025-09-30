<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\HiringPlanItem;
use App\Observers\HiringPlanItemObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
         HiringPlanItem::observe(HiringPlanItemObserver::class);
    }
}
