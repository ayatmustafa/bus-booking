<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CityTripSeat extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id', 'seat_number', 'city_trip_id'
    ];
}
