<?php

namespace Database\Seeders\Car;

use App\Models\Car\CarBodyType;
use Illuminate\Database\Seeder;

class BodyTypeSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		$types = ["Sedan", "Hatchback", "Liftback", "Coupe", "Universal", "Pickup", "SUV", "Allroad", "Cabrio", "Roadster", "Van", "Minivan"];
		foreach ($types as $type) {
			CarBodyType::insert(["name" => $type]);
		}
	}
}
