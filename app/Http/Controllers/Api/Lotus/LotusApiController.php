<?php

namespace App\Http\Controllers\Api\Lotus;

use App\Http\Controllers\Controller;
use App\Http\Resources\LotusReservationResource;
use App\Models\LotusReservation;
use Carbon\Carbon;
use Symfony\Component\HttpKernel\Exception\ConflictHttpException;

class LotusApiController extends Controller
{

    /**
     * Display the specified resource.
     *
     * @param \App\Models\LotusReservation $lotusReservation
     *
     * @return \App\Http\Resources\LotusReservationResource
     */
    public function show (LotusReservation $lotusReservation): LotusReservationResource
    {
        return LotusReservationResource::make($lotusReservation);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Models\LotusReservation $lotusReservation
     *
     * @return \App\Http\Resources\LotusReservationResource
     */
    public function checkIn (LotusReservation $lotusReservation): LotusReservationResource
    {
        if ($lotusReservation->checked_in_at !== null) {
            throw new ConflictHttpException('This reservation has already been checked in.');
        }

        $lotusReservation->checked_in_at = Carbon::now();
        $lotusReservation->save();

        return $this->show($lotusReservation);
    }
}
