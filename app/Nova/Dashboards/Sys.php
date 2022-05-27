<?php

namespace App\Nova\Dashboards;

use Laravel\Nova\Dashboard;
use Stepanenko3\NovaCards\Cards\EnvironmentCard;
use Stepanenko3\NovaCards\Cards\NovaReleaseCard;
use Stepanenko3\NovaCards\Cards\ScheduledJobsCard;
use Stepanenko3\NovaCards\Cards\SslCard;
use Stepanenko3\NovaCards\Cards\SystemResourcesCard;
use Stepanenko3\NovaCards\Cards\VersionsCard;

class Sys extends Dashboard
{

    /**
     * Get the cards for the dashboard.
     * @return array
     */
    public function cards ()
    {
        return [
            new VersionsCard,
            new SystemResourcesCard,
            (new SslCard)->domain('uabvsa.org'),

            (new NovaReleaseCard)->width('1/4'),
            (new EnvironmentCard)->width('1/4'),
            (new ScheduledJobsCard())->startPolling()
                                     ->pollingTime(60 * 1000),

        ];
    }

    /**
     * Get the URI key for the dashboard.
     * @return string
     */
    public function uriKey ()
    {
        return 'sys';
    }
}
