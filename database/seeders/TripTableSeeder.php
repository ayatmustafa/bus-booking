<?php

namespace Database\Seeders;

use App\Models\Bus;
use App\Models\CityTripSeat;
use App\Models\Trip;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TripTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 8; $i++) {
            $start_at = Carbon::createFromTimestamp(fake()->dateTimeBetween($startDate = '+' . $i . ' days', $endDate = '+' . $i + 2 . ' days')->getTimeStamp());
            $trip = Trip::create([
                'name' => Str::random(10),
                'driver_id' => User::all()->random()->id,
                'creator_id' => User::all()->random()->id,
                'bus_id' => Bus::all()->random()->id,
                'start_at' => $start_at,
                'end_at' => Carbon::createFromFormat('Y-m-d H:i:s', $start_at)->addHours(15),
            ]);
            $trip->cities()->attach([
                1 => ['order' => 1, 'arrival_time' => Carbon::createFromFormat('Y-m-d H:i:s', $start_at)->addHours(1)],
                2 => ['order' => 2, 'arrival_time' => Carbon::createFromFormat('Y-m-d H:i:s', $start_at)->addHours(3)],
                3 => ['order' => 3, 'arrival_time' => Carbon::createFromFormat('Y-m-d H:i:s', $start_at)->addHours(4)],
                4 => ['order' => 4, 'arrival_time' => Carbon::createFromFormat('Y-m-d H:i:s', $start_at)->addHours(5)],
                5 => ['order' => 5, 'arrival_time' => Carbon::createFromFormat('Y-m-d H:i:s', $start_at)->addHours(6)],
                6 => ['order' => 6, 'arrival_time' => Carbon::createFromFormat('Y-m-d H:i:s', $start_at)->addHours(8)],
                7 => ['order' => 7, 'arrival_time' => Carbon::createFromFormat('Y-m-d H:i:s', $start_at)->addHours(10)],
                8 => ['order' => 8, 'arrival_time' => Carbon::createFromFormat('Y-m-d H:i:s', $start_at)->addHours(15)],
            ]);

            $city_trip_ids = $trip->cities->pluck('pivot.id');

            foreach ($city_trip_ids as $city_trip_id) {
                for ($j = 1; $j <= 12; $j++) {
                    $city_trip_seat =  CityTripSeat::create(['city_trip_id' => $city_trip_id, 'seat_number' => $j]);
                   // $city_trip_seat->reservation()->create(['user_id' => User::all()->random()->id]);
                }
            }
        }
    }
}
