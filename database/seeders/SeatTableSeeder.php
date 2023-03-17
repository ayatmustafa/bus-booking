<?php

namespace Database\Seeders;

use App\Models\Bus;
use App\Models\Seat;
use Illuminate\Database\Seeder;

class SeatTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 20; $i++) {
            for ($j = 1; $j <= 12; $j++) {
                Seat::firstOrCreate([
                    'bus_id' => $i,
                    'seat_number' => $j . '_' . $i
                ]);
            }
        }
    }
}
