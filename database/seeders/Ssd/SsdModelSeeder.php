<?php

namespace Database\Seeders\Ssd;

use App\Models\Ssd\SsdBrand;
use App\Models\Ssd\SsdModel;
use Illuminate\Database\Seeder;

class SsdModelSeeder extends Seeder {
	public function run(): void {
		$models = [
			"Adata"     => ["XPG SX8200 Pro", "Legend 960 MAX", "Legend 710", "Legend 800", "Legend 960", "XPG Gammix S11 Pro", "Ultimate SU630", "XPG Spectrix", "Swordfish"],
			"Apacer"    => ["AS350 Panther", "AS340X", "AS721", "AS2280P4U", "PPSS25", "AS722", "PPSS80"],
			"Corsair"   => ["Force Series MP600", "EX100U", "MP600", "Neutron Series XT", "Force Series MP400", "MP600 Pro", "Force Series MP300"],
			"Gigabyte"  => ["Aorus", "2500E", "Vision Drive"],
			"GoodRAM"   => ["PX600", "CX400", "HL200", "PX500", "CL100", "IRDM", "IRDM Pro"],
			"HP"        => ["S700", "P500", "EX900", "FX900", "EX950", "EX900 Plus", "S750", "P600"],
			"Intel"     => ["660p Series", "760p Series", "P41 Plus", "600p Series", "750 Series", "670p Series"],
			"Kingston"  => ["A400", "NV2", "KC3000", "SNV2S", "Fury Renegade", "XS2000", "KC600", "A2000"],
			"MSI"       => ["Spatium S270", "Spatium M570", "Spatium M390", "Spatium M480 Pro", "Spatium M450", "Spatium M480"],
			"SanDisk"   => ["Extreme", "X400", "Extreme Pro", "X600", "Ultra"],
			"Samsung"   => ["980 Evo", "970 Evo Plus", "870 EVO", "980 Pro", "970 Evo Plus", "990 Pro", "T7", "T7 Shield"],
			"Transcend" => ["ESD370C", "ESD270C", "SSD225S", "300S", "430S", "MTE250H", "110Q ", "ESD240C"],
			"WD"        => ["Black SN850", "Black SN770", "Blue SN570", "Black SN850X", "Blue SN570", "Green SN350", "Black P40", "Red SN700", "My Passport", "Gold Enterprise", "Ultrastar SN640"],
		];

		$models_to_DB = [];
		$brands = SsdBrand::all();

		foreach ($brands as $brand) {
			foreach ($models[$brand->name] as $model) {
				$models_to_DB[] = ["brand_id" => $brand->id, "name" => $model];
			}
		}
		SsdModel::insert($models_to_DB);
	}
}


