<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LotusReservationResource extends JsonResource
{

    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function toArray ($request): array
    {
        $checkedInAt = $this->tickets_checked_in_at[$this->additional['ticket_number']];
        return [
            "id"                => $this->id,
            "holder_type"       => $this->holderTypeFormatted(),
            "name"              => $this->name,
            "email"             => $this->email,
            "tickets"           => $this->tickets,
            "dietary"           => $this->dietary ?? 'None',
            "accommodations"    => $this->accommodations ?? 'None',
            "affiliation"       => $this->affiliation ?? 'None',
            "confirmed"         => !$this->pending,
            "donation"          => $this->donation ?? 0,
            "checked_in_at"     => $checkedInAt,
            "pending"           => $this->pending,
            "check_in_eligible" => $checkedInAt === NULL && $this->pending !== FALSE,
        ];
    }
}
