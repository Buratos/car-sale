<?php

namespace Database\Seeders\Laptop;

use App\Models\Laptop\LaptopBrand;
use Illuminate\Database\Seeder;

class LaptopBrandSeeder extends Seeder {
	public function run(): void {
		$brands = ["Acer", "Apple", "Asus", "Dell", "Gigabyte", "HP", "Huawei", "Lenovo", "MSI", "LG", "Samsung", "Xiaomi", "Razer"];
		foreach ($brands as $brand) {
			LaptopBrand::insert(["name" => $brand]);
		}
	}
}
