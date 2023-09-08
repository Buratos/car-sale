<?php

namespace App\Http\Requests\Car;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest {
	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize() {
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules() {
		$current_year = Carbon::now()->year;
		return ["car_brand"                            => ["required", "string", "max:25"],
		        "car_model"                            => ["required", "string", "max:25"],
		        "car_gearbox"                          => ["required", "string", "max:30"],
		        "car_engine_type"                      => ["required", "string", "max:30"],
		        "car_engine_capacity"                  => ["required", "numeric", "min:500", "max:11000"],
		        "car_engine_power"                     => ["required", "numeric", "min:20", "max:2000"],
		        "car_fuel_consumption"                 => ["required", "numeric", "min:0", "max:50"],
		        "car_body_type"                        => ["required", "string", "max:30"],
		        "car_number_doors"                     => ["required", "numeric", "min:2", "max:5"],
		        "car_number_places"                    => ["required", "numeric", "min:1", "max:10"],
		        "car_color"                            => ["required", "string", "max:33"],
		        "car_clearance"                        => ["required", "numeric", "min:50", "max:500"],
		        "car_wheelbase"                        => ["required", "numeric", "min:700", "max:5000"],
		        "car_length"                           => ["required", "numeric", "min:1500", "max:7000"],
		        "car_width"                            => ["required", "numeric", "min:500", "max:3000"],
		        "car_height"                           => ["required", "numeric", "min:700", "max:2500"],
		        "car_production_year"                  => ["required", "numeric", "min:1900", "max:$current_year"],
		        "car_mileage"                          => ["required", "numeric", "min:1", "max:10000000"],
		        "car_was_in_accident"                  => ["required", "boolean"],
		        "car_price"                            => ["required", "numeric", "min:1", "max:10000000"],
		        "car_description"                      => ["required", "string", "min:10", "max:4000"],
		        "id_for_link_form_and_uploaded_photos" => ["required", "uuid"],
		        "photo_filenames"                      => ["required", "string"]];
	}
}
