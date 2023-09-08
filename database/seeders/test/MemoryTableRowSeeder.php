<?php

namespace Database\Seeders\test;

use App\Models\test\MemoryTableRow;
use Illuminate\Database\Seeder;

class MemoryTableRowSeeder extends Seeder {
	public function run(): void {
		MemoryTableRow::factory()->count(30000)->create();

	}
}
