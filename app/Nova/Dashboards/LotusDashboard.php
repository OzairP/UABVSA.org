<?php

namespace App\Nova\Dashboards;

use App\Nova\Metrics\Lotus\ReservationsByHolder;
use App\Nova\Metrics\Lotus\TicketReservations;
use App\Nova\Metrics\Lotus\TicketSales;
use Laravel\Nova\Dashboard;

class LotusDashboard extends Dashboard
{
    /**
     * Get the cards for the dashboard.
     *
     * @return array
     */
    public function cards()
    {
        return [
            new TicketReservations(),
            new ReservationsByHolder(),
            new TicketSales()
        ];
    }

    /**
     * Get the URI key for the dashboard.
     *
     * @return string
     */
    public function uriKey()
    {
        return 'lotus';
    }

    public function name ()
    {
        return 'Lotus';
    }

}
