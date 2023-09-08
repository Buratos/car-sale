<?php

namespace Database\Factories\Car;

use App\Models\Car\CarDescription;
use Illuminate\Database\Eloquent\Factories\Factory;

class CarDescriptionFactory extends Factory {
	protected $model = CarDescription::class;

	public function definition(): array {
		return [
			'text' => mb_strimwidth(fake()->paragraphs(mt_rand(2, 5), true), 0, 4000),
		];
	}
}
