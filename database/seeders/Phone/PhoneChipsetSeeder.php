<?php

namespace Database\Seeders\Phone;

use App\Models\Phone\PhoneChipset;
use Illuminate\Database\Seeder;

class PhoneChipsetSeeder extends Seeder {
	public function run(): void {
		$chipsets = ["Qualcomm Snapdragon 8 gen 2", "Qualcomm Snapdragon 8+ gen 1", "Qualcomm Snapdragon 8 gen 1", "Qualcomm Snapdragon 7 gen 2", "Qualcomm Snapdragon 4 gen 2", "Qualcomm Snapdragon 4 gen 1", "Qualcomm Snapdragon 888", "Qualcomm Snapdragon 870", "Qualcomm Snapdragon 788", "Qualcomm Snapdragon 695", "Qualcomm Snapdragon 680", "MediaTek Dimensity 9200", "MediaTek Dimensity 9100", "MediaTek Dimensity 9000+", "MediaTek Dimensity 8100", "MediaTek Dimensity 1080", "MediaTek Dimensity 900", "MediaTek Dimensity 820"];
		foreach ($chipsets as $chipset) {
			PhoneChipset::insert(["name" => $chipset]);
		}
	}
}
