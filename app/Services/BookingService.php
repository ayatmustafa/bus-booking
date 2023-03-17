<?php

namespace App\Services;

use App\Models\Trip;
use App\Models\CityTripSeat;

class BookingService
{
    public  function  getAvailableSeats($request)
    {
        return Trip::with(['bus', 'cityTrip.tripSeats' => function ($q) {
            $q->whereDoesntHave('reservation');
        }, 'cityTrip.tripSeats.seat'])->whereHas('cityTrip', function ($q) use ($request) {
            $q->whereBetween('city_id', [$request->start_station, $request->end_station])
                ->whereHas('tripSeats', function ($query) {
                    $query->whereDoesntHave('reservation');
                });
        })->paginate(15);
    }
    public  function  booking($request)
    {
        $data = CityTripSeat::with(['cityTrip'])
            ->whereHas('seat', function ($query) use ($request) {
                $query->where('seat_number', $request->seat_number);
            })
            ->whereHas('cityTrip', function ($q) use ($request) {
                $q->whereIn('order', range($request->order_start_station, $request->order_end_station - 1))
                    ->where('trip_id', $request->trip_id);
            })->get();
        $data->map(function ($item) {
            $item->reservation()->create(['user_id' => auth()->id()], false);
        });

        return $data;
    }
}
