<?php

namespace Database\Factories\Phone;

use App\Models\Phone\Phone;
use App\Models\Phone\PhoneBrand;
use App\Models\Phone\PhoneChipset;
use App\Models\Phone\PhoneModel;
use Illuminate\Database\Eloquent\Factories\Factory;

class PhoneFactory extends Factory {
	protected $model = Phone::class;

	public function definition(): array {
		$rams = [2, 3, 4, 6, 8, 12, 16, 24];
		$storages = [32, 64, 128, 256, 512, 1024];
		$display_sizes = [6.1, 6.3, 6.4, 6.5, 6.6, 6.67, 6.7, 6.8];
		$cameras = [48, 50, 64, 96, 108];

		$brand_id = PhoneBrand::inRandomOrder()->first()->id;
		$model_id = PhoneModel::where("brand_id", $brand_id)->inRandomOrder()->first()->id;
		$chipset_id = PhoneChipset::inRandomOrder()->first()->id;
		$ram = fake()->randomElement($rams);
		$storage = fake()->randomElement($storages);
		$display_size = fake()->randomElement($display_sizes);
		$camera = fake()->randomElement($cameras);
		$weight = mt_rand(165, 230);
		$price = mt_rand(90, 1000);

		return [
			"brand_id"     => $brand_id,
			"model_id"     => $model_id,
			"chipset_id"   => $chipset_id,
			"ram"          => $ram,
			"storage"      => $storage,
			"display_size" => $display_size,
			"camera"       => $camera,
			"weight"       => $weight,
			"price"        => $price,
		];
	}
}
