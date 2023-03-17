<?php

namespace App\Services;

use App\Models\Trip;
use App\Models\CityTripSeat;
use Illuminate\Support\Facades\DB;

class BookingService
{
    public function getAvailableSeats($request)
    {
        return Trip::with(['bus', 'cityTrip.tripSeats' => function ($q) {
            $q->whereDoesntHave('reservation');
        }, 'cityTrip.tripSeats.seat'])->whereHas('cityTrip', function ($q) use ($request) {
            $q->whereBetween('city_id', [$request->start_station, $request->end_station])
                ->whereHas('tripSeats', function ($query) {
                    $query->whereDoesntHave('reservation');
                });
        })->paginate(config('app.paginate'));
    }

    public function booking($request)
    {
        DB::beginTransaction();
        try {
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
            DB::commit();

            return $data;
        } catch (\Exception $e) {
            DB::rollback();
        }
    }
}
