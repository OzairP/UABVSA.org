<?php

namespace App\Http\Controllers\Api\Lotus;

use App\Http\Controllers\Controller;
use App\Http\Resources\LotusReservationResource;
use App\Models\LotusReservation;
use Carbon\Carbon;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\ConflictHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class LotusApiController extends Controller
{

    /**
     * Display the specified resource.
     *
     * @param \App\Models\LotusReservation $lotusReservation
     *
     * @return \App\Http\Resources\LotusReservationResource
     */
    public function show (LotusReservation $lotusReservation, int $ticketNumber): LotusReservationResource
    {
        if ($ticketNumber < 0) {
            throw new BadRequestHttpException('Ticket number must be greater than 0.');
        }

        if ($lotusReservation->tickets - 1 < $ticketNumber) {
            throw new NotFoundHttpException('This ticket in the reservation does not exist.');
        }

        return LotusReservationResource::make($lotusReservation)->additional([
            'ticket_number' => $ticketNumber,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Models\LotusReservation $lotusReservation
     *
     * @return \App\Http\Resources\LotusReservationResource
     */
    public function checkIn (LotusReservation $lotusReservation, int $ticketNumber): LotusReservationResource
    {
        if ($ticketNumber < 0) {
            throw new BadRequestHttpException('Ticket number must be greater than 0.');
        }

        if ($lotusReservation->tickets < $ticketNumber) {
            throw new NotFoundHttpException('This ticket in the reservation does not exist.');
        }

        if ($lotusReservation->getCheckInTimeForTicket($ticketNumber) !== null) {
            throw new ConflictHttpException('This reservation has already been checked in.');
        }

        $lotusReservation->checkInTicket($ticketNumber);
        $lotusReservation->save();

        return $this->show($lotusReservation, $ticketNumber);
    }
}
