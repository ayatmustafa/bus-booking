<?php

namespace App\Http\Requests;

use App\Models\CityTrip;
use App\Models\CityTripSeat;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BookingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }
    protected function prepareForValidation(): void
    {
        $data = $this->all();
        $data['order_start_station'] = optional(CityTrip::where('trip_id', $this->trip_id)
                ->where('city_id', $this->start_station)->first())->order;
        $data['order_end_station'] = optional(CityTrip::where('trip_id', $this->trip_id)
                ->where('city_id', $this->end_station)->first())->order;
        $data['not_available_seat_number'] = CityTripSeat::where('seat_number', $this->seat_number)
            ->whereHas('cityTrip', function ($q) use ($data) {
                $q->whereIn('order', range($data['order_start_station'], $data['order_end_station']))
                    ->where('trip_id', $this->trip_id);
            })->whereHas('userReservation')->count() == 0 ? "available" : "not available";
        $this->replace($data);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'start_station' => [
                'required',
                'numeric',
                Rule::exists('city_trips', 'city_id')
                    ->where('trip_id', $this->trip_id),
            ],
            'end_station' => [
                'required',
                'numeric',
                Rule::exists('city_trips', 'city_id')
                    ->where('trip_id', $this->trip_id),
            ],
            'trip_id' => [
                'required',
                'numeric',
                Rule::exists('city_trips', 'trip_id'),
            ],
            'seat_number' => [
                'required',
                'numeric',
            ],
            'not_available_seat_number' => ['in:available'],
        ];
    }

    public function messages()
    {
        return [
            'not_available_seat_number' => 'not available to book this seat number',
        ];
    }
}
