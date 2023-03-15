<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id', 'city_trip_seat_id'
    ];
    public function cityTripSeat()
    {
        return $this->belongsTo(CityTripSeat::class, 'city_trip_seat_id');
    }
}
