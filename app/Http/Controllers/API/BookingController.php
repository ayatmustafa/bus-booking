<?php

namespace App\Http\Controllers\API;

use App\Services\BookingService;
use Illuminate\Routing\Controller;
use App\Http\Requests\BookingRequest;
use App\Http\Requests\GetAvailableSeatsRequest;
use App\Http\Resources\AvailableSeatsCollection;

class BookingController extends Controller
{
    protected $bookingService;
    public function __construct(BookingService $bookingService)
    {
        $this->bookingService = $bookingService;
    }
    /**
     * get available seats Req
     */
    public function getAvailableSeats(GetAvailableSeatsRequest $request)
    {
        $data =  $this->bookingService->getAvailableSeats($request);

        return response()->json([
            'status' => true,
            'message' => 'All Available Trips Data',
            'data' => new AvailableSeatsCollection($data),
        ], 200);
    }

    /**
     * get booking seats Req
     */
    public function booking(BookingRequest $request)
    {
        $data = $this->bookingService->booking($request);

        return response()->json([
            'status' => true,
            'message' => 'booking done successfully',
            'data' => $data,
        ], 200);
    }
}
