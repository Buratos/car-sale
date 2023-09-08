<?php

namespace Database\Factories\Car;

use App\Models\Car\CarBodyType;
use App\Models\Car\CarBrand;
use App\Models\Car\CarColor;
use App\Models\Car\CarEngineType;
use App\Models\Car\CarGearbox;
use App\Models\Car\CarModel;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Models\Car\Car>
 */
class CarFactory extends Factory {

	public function definition(): array {

		$brand_id = CarBrand::inRandomOrder()->first()->id;
		$model_id = CarModel::where("brand_id", $brand_id)->inRandomOrder()->first()->id;
		$body_type_id = CarBodyType::inRandomOrder()->first()->id;
		$color_id = CarColor::inRandomOrder()->first()->id;
		$gearbox_id = CarGearbox::inRandomOrder()->first()->id;
		$engine_type_id = CarEngineType::inRandomOrder()->first()->id;
		$production_year = mt_rand(2000, 2022);
		$engine_capacity = 1000 + mt_rand(0, 16) * 300;
		$engine_power = floor($engine_capacity / mt_rand(11,14));
		$fuel_consumption = round(mt_rand(4000, 13000) / 1000, 1);
		$number_doors = mt_rand(2, 5);
		$number_places = mt_rand(2, 7);
		$clearance = mt_rand(100, 300);
		$wheelbase = mt_rand(2300, 3400);
		$length = mt_rand(3600, 5200);
		$width = (integer)($length / (mt_rand(233, 250) / 100));
		$height = mt_rand(1650, 1900);
		$price = mt_rand(3000, 80000);
		$mileage = mt_rand(50, 400000);
		$was_in_accident = mt_rand(0, 1);

		return [
			"brand_id"         => $brand_id,
			"model_id"         => $model_id,
			"body_type_id"     => $body_type_id,
			"color_id"         => $color_id,
			"gearbox_id"       => $gearbox_id,
			"engine_type_id"   => $engine_type_id,
			"engine_capacity"  => $engine_capacity,
			"engine_power"     => $engine_power,
			"fuel_consumption" => $fuel_consumption,
			"production_year"  => $production_year,
			"clearance"        => $clearance,
			"wheelbase"        => $wheelbase,
			"number_doors"     => $number_doors,
			"number_places"    => $number_places,
			"length"           => $length,
			"width"            => $width,
			"height"           => $height,
			"mileage"          => $mileage,
			"was_in_accident"  => $was_in_accident,
			"price"            => $price,
		];
	}
}
