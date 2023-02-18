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
            "checked_in_at"     => $this->checked_in_at,
            "pending"           => $this->pending,
            "check_in_eligible" => $this->checked_in_at === NULL && $this->pending !== FALSE,
        ];
    }
}
