<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CityTrip extends Model
{
    use HasFactory;
    protected $fillable = [
        'trip_id', 'city_id', 'order', 'arrival_time'
    ];
    public  function tripSeats()
    {
        return $this->hasMany(CityTripSeat::class, 'city_trip_id');
    }
    public  function trip()
    {
        return $this->belongsTo(Trip::class, 'trip_id');
    }
    public  function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }
}
