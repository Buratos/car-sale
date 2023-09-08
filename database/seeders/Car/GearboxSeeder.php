<?php

namespace Database\Seeders\Car;

use App\Models\Car\CarGearbox;
use Illuminate\Database\Seeder;

class GearboxSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		$gearboxes = ["Mechanics", "Automatic", "Variator", "Tiptronic", "Robot", "Reducer"];
		foreach ($gearboxes as $gearbox) {
			CarGearbox::insert(["name" => $gearbox]);
		}
	}
}
