<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CityTripSeat extends Model
{
    use HasFactory;
    protected $fillable = [
        'seat_id', 'city_trip_id'
    ];
    public function cityTrip()
    {
        return $this->belongsTo(CityTrip::class, 'city_trip_id');
    }
    public function reservation()
    {
        return $this->hasOne(Reservation::class, 'city_trip_seat_id');
    }
    public function seat()
    {
        return $this->belongsTo(Seat::class, 'seat_id');
    }
}
