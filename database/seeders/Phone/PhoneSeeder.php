<?php

namespace Database\Seeders\Phone;

use App\Models\Phone\Phone;
use Illuminate\Database\Seeder;

class PhoneSeeder extends Seeder {
	public function run(): void {
		Phone::factory()->count(25000)->create();
	}
}
