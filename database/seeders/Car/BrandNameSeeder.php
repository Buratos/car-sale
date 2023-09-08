<?php

namespace Database\Seeders\Car;

use App\Models\Car\CarBrand;
use Illuminate\Database\Seeder;

class BrandNameSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run(): void {
		$brands = ["Audi", "BMW", "Opel", "Suzuki", "Peugeot", "Skoda", "Toyota", "Renault", "Kia", "Hyundai", "Fiat", "Cherry", "Ford", "Dodge", "Chrysler", "Mercedes", "Cadillac", "Chevrolet", "Volkswagen", "Nissan", "Honda", "Mitsubishi", "Mazda", "Citroen", "Land Rover", "Jeep", "Seat"];
		foreach ($brands as $brand) {
			CarBrand::insert(["name" => $brand]);
		}
	}
}
