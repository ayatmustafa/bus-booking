<?php

namespace App\Http\Controllers\API;

use App\Exceptions\ExceptionMessage;
use App\Http\Requests\BookingRequest;
use App\Http\Requests\GetAvailableSeatsRequest;
use App\Models\CityTrip;
use App\Models\CityTripSeat;
use App\Models\Trip;
use Illuminate\Routing\Controller;
use PhpParser\Node\Stmt\Foreach_;

class BookingController extends Controller
{
    /**
     * get available seats Req
     */
    public function getAvailableSeats(GetAvailableSeatsRequest $request)
    {
        return Trip::with('cityTrip.tripSeats.reservation')
                ->whereDoesntHave('cityTrip.tripSeats.reservation')->get();

        return response()->json([
            'status' => true,
            'message' => 'all available trips data',
            //'data' => $data,
        ], 200);
    }

    /**
     * get booking seats Req
     */
    public function booking(BookingRequest $request)
    {
        $data = CityTripSeat::with(['cityTrip', 'reservation', 'userReservation'])
        ->where('seat_number', $request->seat_number)
        ->whereHas('cityTrip', function($q) use($request){
            $q->whereIn('order', range($request->order_start_station, $request->order_end_station))
                ->where('trip_id', $request->trip_id);
        })->get(); 

        $data->map(function ($item) {
           $item->userReservation()->sync([auth()->id()]);
        });

        return response()->json([
            'status' => true,
            'message' => 'booking done successfully',
            'data' => $data,
        ], 200);     
    }
}
