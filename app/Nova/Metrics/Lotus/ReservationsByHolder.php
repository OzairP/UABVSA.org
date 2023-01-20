<?php

namespace App\Nova\Metrics\Lotus;

use App\Models\LotusReservation;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Partition;

class ReservationsByHolder extends Partition
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
        return $this->sum($request, LotusReservation::class, 'tickets', 'holder_type')
                    ->label(function ($value) {
                        return ucfirst($value);
                    });
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
        return 'lotus-reservations-by-holder';
    }

    public function name ()
    {
        return 'Reservations by Holder';
    }


}
