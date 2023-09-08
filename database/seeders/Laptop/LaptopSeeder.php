<?php

namespace Database\Seeders\Laptop;

use App\Models\Laptop\Laptop;
use Illuminate\Database\Seeder;

class LaptopSeeder extends Seeder {
	public function run(): void {
		Laptop::factory()->count(10000)->create();
	}
}
