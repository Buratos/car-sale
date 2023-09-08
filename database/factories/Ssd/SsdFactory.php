<?php

namespace Database\Factories\Ssd;

use App\Models\Ssd\Ssd;
use App\Models\Ssd\SsdBrand;
use App\Models\Ssd\SsdInterface;
use App\Models\Ssd\SsdModel;
use Illuminate\Database\Eloquent\Factories\Factory;

class SsdFactory extends Factory {
	protected $model = Ssd::class;

	public function definition(): array {
		$capacities = [240, 256, 480, 512, 960, 1024, 2048, 4096];

		$brand_id = SsdBrand::inRandomOrder()->first()->id;
		$model_id = SsdModel::where("brand_id", $brand_id)->inRandomOrder()->first()->id;
		$type = mt_rand(1, 2);
		$capacity = fake()->randomElement($capacities);
		$interface_id = SsdInterface::inRandomOrder()->first()->id;
		$speed_read = round(mt_rand(500, 7500) / 100) * 100;
		$speed_write = round($speed_read * 0.9 / 100) * 100;
		$price = mt_rand(10, 500);

		return [
			"brand_id"     => $brand_id,
			"model_id"     => $model_id,
			"type"         => $type,
			"capacity"     => $capacity,
			"interface_id" => $interface_id,
			"speed_read"   => $speed_read,
			"speed_write"  => $speed_write,
			"price"        => $price,
		];
	}
}
