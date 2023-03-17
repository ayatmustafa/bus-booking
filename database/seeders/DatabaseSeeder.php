<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(UserTableSeeder::class);
        $this->call(BusTableSeeder::class);
        $this->call(SeatTableSeeder::class);
        $this->call(CityTableSeeder::class);
        $this->call(TripTableSeeder::class);
    }
}
