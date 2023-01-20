<?php

namespace App\Nova\Metrics\Lotus;

use App\Models\LotusReservation;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Trend;

class TicketReservations extends Trend
{

    /**
     * Calculate the value of the metric.
     *
     * @param \Laravel\Nova\Http\Requests\NovaRequest $request
     *
     * @return mixed
     */
    public function calculate (NovaRequest $request)
    {
        return $this->sumByMinutes($request, LotusReservation::class, 'tickets')
                    ->showSumValue();
    }

    /**
     * Get the ranges available for the metric.
     * @return array
     */
    public function ranges ()
    {
        return [
            15 => __('15 Minutes'),
            30 => __('30 Minutes'),
            60 => __('1 Hour'),
            120 => __('2 Hours'),
            240 => __('4 Hours'),
        ];
    }

    /**
     * Determine the amount of time the results of the metric should be cached.
     * @return \DateTimeInterface|\DateInterval|float|int|null
     */
    public function cacheFor ()
    {
        // return now()->addMinutes(5);
    }

    /**
     * Get the URI key for the metric.
     * @return string
     */
    public function uriKey ()
    {
        return 'lotus-ticket-reservations';
    }
}
