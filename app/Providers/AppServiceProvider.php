<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Kra8\Snowflake\Snowflake;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {

        $this->app->singleton(Snowflake::class, function () {
            $epoch = config('snowflake.epoch', null);
            $workerId = config('snowflake.worker_id', 1);
            $datacenterId = config('snowflake.datacenter_id', 1);
            $timestamp = $epoch === null ? null :  $timestamp = strtotime($epoch);
            return new Snowflake($timestamp, $workerId, $datacenterId);
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
