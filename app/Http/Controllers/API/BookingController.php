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
        $trips =  Trip::query();
        foreach ((clone $trips->get()) as $k => $trip) {
            $data[$k]['trip'] = $trip;
            $orderOfStartStation = optional($trip->cities->pluck('pivot')->where('city_id', $request->start_station)->first())->order;
            $orderOfEndStation = optional($trip->cities->pluck('pivot')->where('city_id', $request->end_station)->first())->order;

            if ($orderOfEndStation > $orderOfStartStation) {
                $CityTrip = CityTrip::with('tripSeats')->where('trip_id', $trip->id)
                    ->whereBetween('order', [$orderOfStartStation, $orderOfEndStation])->get();

                $CityTripIds = (clone $CityTrip)->pluck('id');
                for ($i = 1; $i <= 12; $i++) {
                    $notAvailableSeat = CityTripSeat::whereIn('city_trip_id', $CityTripIds)
                        ->where('seat_number', $i)->whereNotNull('user_id');

                    if ((clone $notAvailableSeat)->get()->count() == 0) {

                        $availableSeats[] = $i;
                    }
                }
                $data[$k]["seats"] = $availableSeats;
            }
        }

        return response()->json([
            'status' => true,
            'message' => 'all available trips data',
            'data' => $data,
        ], 200);
    }

    /**
     * get booking seats Req
     */
    public function booking(BookingRequest $request)
    {
        $cityTrip =  CityTrip::where('trip_id', $request->trip_id)->whereHas('availableTripSeats');
        $orderOfStartStation = optional((clone $cityTrip)->where('city_id', $request->start_station)->first())->order;
        $orderOfEndStation = optional((clone $cityTrip)->where('city_id', $request->end_station)->first())->order;

        if ($orderOfEndStation > $orderOfStartStation) {
            $data = CityTripSeat::with('cityTrip')->whereNull('user_id')->where('seat_number', $request->seat_number)
                ->whereHas('cityTrip', function ($q) use ($orderOfEndStation, $orderOfStartStation, $request) {
                    $q->whereBetween('order', [$orderOfStartStation, $orderOfEndStation])
                        ->where('trip_id', $request->trip_id);
                })->update(['user_id' => auth()->id()]);

            return response()->json([
                'status' => true,
                'message' => 'booking done successfully',
                'data' => $data,
            ], 200);
        }

        throw new ExceptionMessage("not available to book this seat");
    }
}
