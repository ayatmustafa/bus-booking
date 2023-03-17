<?php

namespace App\Http\Controllers\API;

use App\Models\Trip;
use App\Models\CityTripSeat;
use Illuminate\Routing\Controller;
use App\Http\Requests\BookingRequest;
use App\Http\Requests\GetAvailableSeatsRequest;

class BookingController extends Controller
{
    /**
     * get available seats Req
     */
    public function getAvailableSeats(GetAvailableSeatsRequest $request)
    {
        $data = Trip::with(['cityTrip.tripSeats' => function ($q) {
            $q->whereDoesntHave('reservation');
        }, 'cityTrip.tripSeats.seat'])->whereHas('cityTrip', function ($q) use ($request) {
            $q->whereBetween('city_id', [$request->start_station, $request->end_station])
                ->whereHas('tripSeats', function ($query) {
                    $query->whereDoesntHave('reservation');
                });
        })->get();

        return response()->json([
            'status' => true,
            'message' => 'All Available Trips Data',
            'data' => $data,
        ], 200);
    }

    /**
     * get booking seats Req
     */
    public function booking(BookingRequest $request)
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
            $item->userReservation()->sync([auth()->id()], false);
        });

        return response()->json([
            'status' => true,
            'message' => 'booking done successfully',
            'data' => $data,
        ], 200);
    }
}
