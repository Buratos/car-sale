<?php

namespace App\Http\Requests\Car;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest {
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
//      return [];
      return ["id" => ["required", "integer"], "brand" => ["required", "string", "min:2"], "car_model" => ["required", "string", "min:2"], "engine_capacity" => ["required", "integer", "between:700,10000"], "engine_type" => ["required", "string", "in:Petrol,Diesel,Hybrid,Electric,Gas"], "engine_power" => ["required", "integer", "between:20,2000"], "production_year" => ["required", "integer", "max:$current_year"], "number_doors" => ["required", "integer", "between:2,5"], "number_places" => ["required", "integer", "between:2,7"], "description" => ["nullable", "string", "max:4000"], "dimensions_length" => ["required", "integer", "between:1500,8000"], "dimensions_width" => ["required", "integer", "between:500,3000"], "dimensions_height" => ["required", "integer", "between:500,2500"], "price" => ["required", "integer"], "mileage" => ["required", "integer", "nullable"], "was_in_accident" => ["required", "integer", "in:0,1"], "body_type" => ["required", "string", "in:Sedan,Hatchback,Liftback,Coupe,Universal,Pickup,SUV,Allroad,Cabrio,Roadster,Van,Minivan"], "color" => ["required", "string"], "vehicle_drive_type" => ["required", "string", "in:All wheel drive,Front-wheel drive,Rear drive"], "gearbox" => ["required", "string", "in:Mechanics,Automatic,Variator,Tiptronic,Robot,Reducer"]];
   }
}
