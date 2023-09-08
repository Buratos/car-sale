<?php

namespace Database\Seeders\Ssd;

use App\Models\Ssd\Ssd;
use Illuminate\Database\Seeder;

class SsdSeeder extends Seeder {
	public function run(): void {
		Ssd::factory()->count(5000)->create();
	}
}
