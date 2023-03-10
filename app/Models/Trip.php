<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    use HasFactory;
    protected $fillable = [
        'name', 'driver_id', 'creator_id', 'bus_id', 'end_at', 'start_at', 'seat_price'
    ];
}
