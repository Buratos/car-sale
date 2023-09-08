<?php

namespace Database\Seeders\Laptop;

use App\Models\Laptop\LaptopBrand;
use App\Models\Laptop\LaptopModel;
use Illuminate\Database\Seeder;

class LaptopModelSeeder extends Seeder {
	public function run(): void {
		$models = [
			"Acer"     => ["Aspire", "Chromebook", "ConceptD", "Nitro", "Predator", "Spin", "Swift", "TravelMate"],
			"Apple"    => ["MacBook Air", "MacBook Pro"],
			"Asus"     => ["Chromebook", "ExpertBook", "ProArt", "ROG Flow", "ROG Strix", "ROG Zephyrus", "StudioBook", "TUF Gaming", "VivoBook", "ZenBook"],
			"Dell"     => ["Alienware", "Inspiron", "Latitude", "Precision", "Vostro", "XPS"],
			"Gigabyte" => ["Aorus", "Aero", "G5", "A7"],
			"HP"       => ["Elite", "EliteBook", "Envy", "Omen", "Pavilion", "Pavilion Gaming", "ProBook", "Spectre", "ZBook", "Victus"],
			"Huawei"   => ["Matebook B3", "Matebook D", "Matebook", "MagicBook X"],
			"Lenovo"   => ["IdeaPad 1", "IdeaPad 3", "IdeaPad Slim", "IdeaPad 5", "Legion 5", "Legion 5 pro", "Legion 7", "Legion 7 Pro", "ThinkBook", "ThinkPad", "ThinkPad X1 Nano", "Yoga 6", "Yoga 7", "Yoga Slim"],
			"MSI"      => ["Alpha", "Bravo", "Creator", "Leopard", "Modern", "Prestige", "Raider", "Stealth", "Thin"],
			"LG"       => ["Ultra PC", "Gram 2022", "Gram 2023"],
			"Samsung"  => ["Chromebook", "Galaxy Book", "Galaxy Book Pro", "Galaxy Book Ion", "Galaxy Book 2", "Galaxy Book 2 Pro", "Galaxy Book 3", "Galaxy Book 3 Pro"],
			"Xiaomi"   => ["Mi Gaming Laptop", "Mi Notebook", "Redmi G", "RedmiBook", "Mi Notebook Air", "RedmiBook Air", "RedmiBook Pro", "Book Pro"],
			"Razer"    => ["Blade Stealth", "Book", "Blade", "Blade Pro", "Blade Advanced"],
		];

		$models_to_DB = [];
		$brands = LaptopBrand::all();

		foreach ($brands as $brand) {
			foreach ($models[$brand->name] as $model) {
				$models_to_DB[] = ["brand_id" => $brand->id, "name" => $model];
			}
		}
		LaptopModel::insert($models_to_DB);
	}

}

