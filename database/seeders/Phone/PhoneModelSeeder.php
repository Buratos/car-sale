<?php

namespace Database\Seeders\Phone;

use App\Models\Phone\PhoneBrand;
use App\Models\Phone\PhoneModel;
use Illuminate\Database\Seeder;

class PhoneModelSeeder extends Seeder {
	public function run(): void {
		$models = [
			"Apple"     => [" iPhone 14 Pro", "iPhone 13", "iPhone 14 Pro Max", "iPhone 13 Pro", "Apple iPhone 14", "Apple iPhone 13 Pro Max"],
			"Asus"      => ["ZenFone 9", "ROG Phone 7", "ZenFone 8", "ROG Phone 6", "ROG Phone 6D", "Asus ZenFone 10"],
			"Blackview" => ["Oscal S80", "Oscal C80", "Oscal C30 Pro", "BV5300 Pro", "BV7100", "BV9200", "A80 Plus", "BV6600"],
			"Google"    => ["Pixel 6a", "Pixel 7", "Pixel 7a", "Pixel 7 Pro", "Pixel 6 Pro"],
			"Huawei"   => ["Nova 10", "Mate 50 Pro", "Nova 9 SE", "Nova 10 SE", "P40 Pro", "P40"],
			"Motorola" => ["Moto G32", "Moto G72", "Edge 40", "Moto G71", "Moto G60", "Razr 40 Ultra", "Edge 30 Neo", "Edge 20", "Edge 40 Pro"],
			"Nokia"    => ["G60", "X30 5G", "X10", "G21", "C21 Plus", "C32", "G22", "C31"],
			"OnePlus"  => ["Ace 2", "Nord CE 3 Lite", "11", "Ace", "10 Pro", "10R", "9", "Ace Pro", "Nord 2", "Nord"],
			"Samsung"  => ["A54 5G", "A24", "S23", "A34 5G", "A73 5G", "M14", "S22", "M33 5G", "S21 FE", "M53 5G"],
			"Xiaomi"   => ["13 Lite", "13", "13 Pro", "12", "12T", "12T Pro", "12 Lite", "12S Ultra", "12X", "13 Ultra"],
			"Poco"     => ["F3", "F5", "X5 Pro", "M5s", "M5", "C40", "X5", "F5 Pro"],
			"Redmi"    => ["Note 12", "Note 12 Pro", "Note 12S", "Note 12 Turbo", "K60", "12C", "Note 11", "10C"]
		];

		$models_to_DB = [];
		$brands = PhoneBrand::all();

		foreach ($brands as $brand) {
			foreach ($models[$brand->name] as $model) {
				$models_to_DB[] = ["brand_id" => $brand->id, "name" => $model];
			}
		}
		PhoneModel::insert($models_to_DB);
	}
}
