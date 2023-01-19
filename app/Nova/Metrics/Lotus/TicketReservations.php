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
        return $this->countByDays($request, LotusReservation::class)
                    ->showSumValue();
    }

    /**
     * Get the ranges available for the metric.
     * @return array
     */
    public function ranges ()
    {
        return [
            3 => __('3 Days'),
            7 => __('7 Days'),
            14 => __('14 Days'),
            31 => __('31 Days'),
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
