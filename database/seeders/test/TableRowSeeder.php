<?php

namespace Database\Seeders\test;

use App\Models\test\TableRow;
use Illuminate\Database\Seeder;

class TableRowSeeder extends Seeder {
	public function run(): void {
		TableRow::factory()->count(30000)->create();

	}
}
