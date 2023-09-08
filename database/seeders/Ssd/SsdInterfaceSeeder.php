<?php

namespace Database\Seeders\Ssd;

use App\Models\Ssd\SsdInterface;
use Illuminate\Database\Seeder;

class SsdInterfaceSeeder extends Seeder {
	public function run(): void {
		$interfaces = ["SATA3 6Gb/s", "SATA2 3Gb/s", "USB 3.2 Gen1", "USB C 3.2 Gen1", "USB C 3.2 Gen2", "USB C 3.2 Gen2x2", "PCI-E 5.0 x4", "PCI-E 4.0 x4", "PCI-E 3.0 x8", "PCI-E 3.0 x4", "M.2", "NVMe"];
		foreach ($interfaces as $interface) {
			SsdInterface::insert(["name" => $interface]);
		}
	}
}
