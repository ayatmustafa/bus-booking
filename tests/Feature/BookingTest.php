<?php

namespace Tests\Feature\Http;

use App\Models\Trip;
use App\Models\User;
use Laravel\Passport\Passport;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class BookingTest extends TestCase
{
    use RefreshDatabase;
    use DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();
        $this->seed();
        $this->seed(DatabaseSeeder::class);
        \Artisan::call('passport:install');
    }

    public function login()
    {
        $user = User::first();
        Passport::actingAs($user);

        //See Below
        return  $user->generateToken();
    }
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testSingleBookStationPerSeatShouldPass()
    {
        $token =  $this->login();
        $response = $this->postJson(
            'api/booking-seat/',
            [
                "seat_number" => "3_1",
                "start_station" => 1,
                "end_station" => 4,
                "trip_id" => 1
            ],
            ['Authorization' => "Bearer $token"]

        );
        $response->assertOk();
        $response->assertJson([
            "status" => true,
            "message" => "booking done successfully",
        ]);
    }

    public function testTryToBookMultipleStationsOnTheSameSeatSuccessfully()
    {
        $token =  $this->login();
        $responseFrom1To4 = $this->postJson(
            'api/booking-seat/',
            [
                "seat_number" => "3_1",
                "start_station" => 1,
                "end_station" => 4,
                "trip_id" => 1
            ],
            ['Authorization' => "Bearer $token"]

        );
        $responseFrom1To4->assertOk();
        $responseFrom1To4->assertJson([
            "status" => true,
            "message" => "booking done successfully",
        ]);

        $responseFrom4To7 = $this->postJson(
            'api/booking-seat/',
            [
                "seat_number" => "3_1",
                "start_station" => 4,
                "end_station" => 7,
                "trip_id" => 1
            ],
            ['Authorization' => "Bearer $token"]

        );
        $responseFrom4To7->assertOk();
        $responseFrom4To7->assertJson([
            "status" => true,
            "message" => "booking done successfully",
        ]);
    }

    public function testTryToBookOverlapMultipleStationsOnTheSameSeatShouldFail()
    {
        $token =  $this->login();
        $responseFrom1To5 = $this->postJson(
            'api/booking-seat/',
            [
                "seat_number" => "7_1",
                "start_station" => 1,
                "end_station" => 5,
                "trip_id" => 1
            ],
            ['Authorization' => "Bearer $token"]

        );
        $responseFrom1To5->assertOk();
        $responseFrom1To5->assertJson([
            "status" => true,
            "message" => "booking done successfully",
        ]);

        $duplicatedFrom1To5 = $this->postJson(
            'api/booking-seat/',
            [
                "seat_number" => "7_1",
                "start_station" => 1,
                "end_station" => 5,
                "trip_id" => 1
            ],
            ['Authorization' => "Bearer $token"]

        );
        $duplicatedFrom1To5->assertUnprocessable();
        $overlappingFrom1_5To2_7 = $this->postJson(
            'api/booking-seat/',
            [
                "seat_number" => "7_1",
                "start_station" => 2,
                "end_station" => 7,
                "trip_id" => 1
            ],
            ['Authorization' => "Bearer $token"]

        );
        $overlappingFrom1_5To2_7->assertUnprocessable();
    }
}
