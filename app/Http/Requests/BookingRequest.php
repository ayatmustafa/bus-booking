<?php

namespace App\Http\Requests;

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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            "start_station" => [
                'required',
                'numeric',
                Rule::exists('city_trips', 'city_id')
                    ->where('trip_id', $this->trip_id)
            ],
            "end_station" => [
                'required',
                'numeric',
                Rule::exists('city_trips', 'city_id')
                    ->where('trip_id', $this->trip_id)
            ],
            "trip_id" => [
                'required',
                'numeric',
                Rule::exists('city_trips', 'trip_id')
            ],
            "seat_number" => [
                'required',
                'numeric'
            ],
        ];
    }
}
