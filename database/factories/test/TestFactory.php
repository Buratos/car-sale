<?php

namespace Database\Factories\test;

use Illuminate\Database\Eloquent\Factories\Factory;

class TestFactory extends Factory {

	public function definition(): array {
		$brand = $this->faker->randomElement(["Audi", "BMW", "Opel", "Suzuki", "Peugeot", "Skoda", "Toyota", "Renault", "Kia", "Hyundai", "Fiat", "Cherry", "Ford", "Dodge", "Chrysler", "Mercedes", "Cadillac", "Chevrolet", "Volkswagen", "Nissan", "Honda", "Mitsubishi", "Mazda"]);

		$model = $this->faker->randomElement(["Corolla", "Camry", "Avalon", "RAV4", "Land Cruiser 200", "Land Cruiser 300", "Land Cruiser Prado", "Avensis", "Prius", "Highlander", "Fortuner", "Hilux", "Yaris",]);

		$power = $this->faker->randomElement([100, 110, 120, 130, 140, 150, 160, 170, 180, 190, 200, 210, 220, 230, 240, 250, 260, 270, 280, 290, 300]);

		return [
			'brand'       => $brand,
			'brand_index' => $brand,
			'model'       => $model,
			'model_index' => $model,
			'power'       => $power,
			'power_index' => $power,
		];
	}
}
