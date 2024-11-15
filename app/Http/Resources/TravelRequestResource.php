<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TravelRequestResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'requester_name' => $this->requester_name,
            'destination' => $this->destination,
            'departure_date' => $this->departure_date,
            'return_date' => $this->return_date,
            'travel_status' => $this->travelStatus->status_name,
        ];
    }
}
