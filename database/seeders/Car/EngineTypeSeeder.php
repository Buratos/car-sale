<?php

namespace Database\Seeders\Car;

use App\Models\Car\CarEngineType;
use Illuminate\Database\Seeder;

class EngineTypeSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		$types = ["Petrol", "Diesel", "Hybrid", "Electric", "Gas"];
		foreach ($types as $type) {
			CarEngineType::insert(["name" => $type]);
		}
	}
}
