<?php

namespace Database\Seeders\Phone;

use App\Models\Phone\PhoneBrand;
use Illuminate\Database\Seeder;

class PhoneBrandSeeder extends Seeder {
	public function run(): void {
		$brands = ["Apple", "Asus", "Blackview", "Google", "Huawei", "Motorola", "Nokia", "OnePlus", "Samsung", "Xiaomi", "Poco", "Redmi"];
		foreach ($brands as $brand) {
			PhoneBrand::insert(["name" => $brand]);
		}
	}
}
