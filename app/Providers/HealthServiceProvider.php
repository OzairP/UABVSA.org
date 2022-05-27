<?php

namespace App\Providers;

use App\Checks\DiscordAPIHealthCheck;
use Illuminate\Support\ServiceProvider;
use Spatie\CpuLoadHealthCheck\CpuLoadCheck;
use Spatie\Health\Checks\Checks\CacheCheck;
use Spatie\Health\Checks\Checks\DatabaseCheck;
use Spatie\Health\Checks\Checks\DebugModeCheck;
use Spatie\Health\Checks\Checks\EnvironmentCheck;
use Spatie\Health\Checks\Checks\RedisCheck;
use Spatie\Health\Checks\Checks\ScheduleCheck;
use Spatie\Health\Checks\Checks\UsedDiskSpaceCheck;
use Spatie\Health\Facades\Health;

class HealthServiceProvider extends ServiceProvider
{

    /**
     * Register services.
     * @return void
     */
    public function register ()
    {
        //
    }

    /**
     * Bootstrap services.
     * @return void
     */
    public function boot ()
    {
        Health::checks([
            DebugModeCheck::new(),
            EnvironmentCheck::new(),
            ScheduleCheck::new(),
            CacheCheck::new(),
            DatabaseCheck::new(),
            RedisCheck::new(),
            DiscordAPIHealthCheck::new(),
            UsedDiskSpaceCheck::new(),
            CpuLoadCheck::new()
                        ->failWhenLoadIsHigherInTheLast5Minutes(2.0)
                        ->failWhenLoadIsHigherInTheLast15Minutes(1.5),
        ]);
    }
}
