<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AvailableSeatsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'trip_id' => $this->id,
            'trip_name' => $this->name,
            'start_at' => $this->start_at,
            'end_at' => $this->end_at,
            'bus_details' => new BusResource($this->bus),
            'available_seats' => $this->cityTrip->first()->tripSeats->pluck('seat')
        ];
    }
}
