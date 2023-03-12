<?php

namespace App\Models;

use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string $name
 * @property int $driver_id
 * @property int $creator_id
 * @property int $bus_id
 * @property DateTime $end_at
 * @property DateTime $start_at
 */
class Trip extends Model
{
    use HasFactory;
    protected $fillable = [
        'name', 'driver_id', 'creator_id', 'bus_id', 'end_at', 'start_at'
    ];
    public function cities()
    {
        return $this->belongsToMany(City::class, 'city_trips',  'trip_id', 'city_id')
            ->withPivot(['id', 'order', 'arrival_time'])->withTimestamps();
    }
    public  function cityTrip()
    {
        return $this->hasMany(CityTrip::class, 'trip_id');
    }
}
