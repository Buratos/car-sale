<?php

namespace Database\Factories\Laptop;

use App\Models\Laptop\Laptop;
use App\Models\Laptop\LaptopBrand;
use App\Models\Laptop\LaptopCpu;
use App\Models\Laptop\LaptopDisplayResolution;
use App\Models\Laptop\LaptopGraphicsCard;
use App\Models\Laptop\LaptopModel;
use Illuminate\Database\Eloquent\Factories\Factory;

class LaptopFactory extends Factory {
	protected $model = Laptop::class;

	public function definition(): array {
		$rams = [8, 16, 24, 32, 48, 64];
		$ssds = [512, 1024, 2048, 4096];
		$display_sizes = [13, 14, 15.6, 16, 17, 17.3];

		$brand_id = LaptopBrand::inRandomOrder()->first()->id;
		$model_id = LaptopModel::where("brand_id", $brand_id)->inRandomOrder()->first()->id;
		$cpu_id = LaptopCpu::inRandomOrder()->first()->id;
		$graphics_card_id = LaptopGraphicsCard::inRandomOrder()->first()->id;
		$ram = fake()->randomElement($rams);
		$ssd = fake()->randomElement($ssds);
		$display_size = fake()->randomElement($display_sizes);
		$display_resolution_id = LaptopDisplayResolution::inRandomOrder()->first()->id;
		$battery_power = mt_rand(50, 97);
		$weight = mt_rand(990, 3100);
		$price = mt_rand(600, 3000);

		return [
			"brand_id"              => $brand_id,
			"model_id"              => $model_id,
			"cpu_id"                => $cpu_id,
			"graphics_card_id"      => $graphics_card_id,
			"ram"                   => $ram,
			"ssd"                   => $ssd,
			"display_size"          => $display_size,
			"display_resolution_id" => $display_resolution_id,
			"battery_power"         => $battery_power,
			"weight"                => $weight,
			"price"                 => $price,
		];
	}
}
