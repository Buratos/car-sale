<?php

namespace Database\Factories\test;

use Illuminate\Database\Eloquent\Factories\Factory;

class TableRowFactory extends Factory {
	public function definition(): array {
		return [
			'name'     => fake()->text(20),
			"price"    => mt_rand(2000, 4000),
			"category" => mt_rand(1, 10),
			"weight"   => mt_rand(50, 1000),
		];
	}
}
