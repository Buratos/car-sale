<?php

namespace Database\Seeders\Car;

use App\Models\Car\CarColor;
use Illuminate\Database\Seeder;

class ColorSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		$colors = [["Beige", "#F1D9B2"], ["Black", "#000000"], ["Blue", "#334DFF"], ["Brown", "#926547"], ["Green", "#35BA2B"], ["Grey", "#9C9999"], ["Orange", "#F57D00"], ["Purple", "#9966CC"], ["Red", "#FC4829"], ["White", "#FFFFFF"], ["Yellow", "#FDE90F"]];
		foreach ($colors as $color) {
			CarColor::insert(["name" => $color[0] . "--" . $color[1]]);
		}
	}
}
