<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\BusStopSchedule;
use App\Policies\BusStopSchedulePolicy;

class AppServiceProvider extends ServiceProvider
{
    protected $policies = [
        BusStopSchedule::class => BusStopSchedulePolicy::class,
    ];
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
