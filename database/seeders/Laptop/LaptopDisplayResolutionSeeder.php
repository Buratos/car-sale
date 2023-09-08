<?php

namespace Database\Seeders\Laptop;

use App\Models\Laptop\LaptopDisplayResolution;
use Illuminate\Database\Seeder;

class LaptopDisplayResolutionSeeder extends Seeder {
	public function run(): void {
		$resolutions = ["3840x2400", "3840x2160 UHD (4K)", "3456x2234", "2880x1800",  "2560x1600", "2560x1440", "1920x1200", "1920x1080"];
		foreach ($resolutions as $resolution) {
			LaptopDisplayResolution::insert(["name" => $resolution]);
		}
	}
}
