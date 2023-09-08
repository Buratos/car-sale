<?php

namespace Database\Seeders\Ssd;

use App\Models\Ssd\SsdBrand;
use Illuminate\Database\Seeder;

class SsdBrandSeeder extends Seeder {
	public function run(): void {
		$brands = ["Adata", "Apacer", "Corsair", "Gigabyte", "GoodRAM", "HP", "Intel", "Kingston", "MSI", "SanDisk", "Samsung", "Transcend", "WD"];
		foreach ($brands as $brand) {
			SsdBrand::insert(["name" => $brand]);
		}
	}
}
