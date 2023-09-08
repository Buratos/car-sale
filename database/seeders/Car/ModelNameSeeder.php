<?php

namespace Database\Seeders\Car;

use App\Models\Car\CarBrand;
use App\Models\Car\CarModel;
use Illuminate\Database\Seeder;

class ModelNameSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */

	public function run(): void {
		$models = [
			"Audi"       => ["A2", "A3", "A4", "A6", "Q3", "Q5", "Q7", "Q9", "RS4", "RS6", "RS8"],
			"BMW"        => ["X3", "X5", "X2", "X1", "135i", "540i", "320", "Z4"],
			"Opel"       => ["Astra", "Zafira", "Vectra", "Omega", "Insignia", "Mokka", "Corsa", "Meriva", "Signum"],
			"Suzuki"     => ["Vitara", "Swift", "Grand Vitara", "SX4", "Jimmy", "Splash", "Liana", "Ignis"],
			"Peugeot"    => ["208", "301", "2008", "508", "3008", "Rifter", "5008"],
			"Skoda"      => ["Octavia", "Fabia", "Yeti", "Superb", "Roomster", "Rapid", "Octavia RS", "Kodiaq"],
			"Toyota"     => ["Corolla", "Camry", "Avalon", "RAV4", "Land Cruiser 200", "Land Cruiser 300", "Land Cruiser Prado", "Avensis", "Prius", "Highlander", "Fortuner", "Hilux", "Yaris",],
			"Renault"    => ["Logan", "Sandero", "Duster", "Arkana", "Captur", "Megane", "Lodgy", "Trafic", "Koleos", "Express"],
			"Kia"        => ["Rio", "Sportage", "Cerato", "Sorento", "Soul", "Ceed", "Picanto", "Carnival", "Carens", "Mohave"],
			"Hyundai"    => ["i10", "i20", "i30", "i40", "Elantra", "Tucson", "Santa Fe", "Kona", "Venue"],
			"Fiat"       => ["Bravo", "Croma", "Doblo", "Ducato", "Freemont", "Fullback", "500", "500L", "Punto", "Tipo", "500X Urban"],
			"Cherry"     => ["Very", "Tiggo", "Indis", "M11", "Arrizo"],
			"Ford"       => ["Mustang", "F150", "Mondeo", "Focus", "Explorer", "Fiesta", "Kuga", "Tourneo Connect", "Ranger", "Transit"],
			"Dodge"      => ["Challenger", "Avenger", "Attitude", "Charger", "Durango", "Journey", "Neon", "Nitro", "Ram", "Viper"],
			"Chrysler"   => ["300C", "Concorde", "Crossfire", "Delta", "Grand Voyadger", "PT Cruiser", "Sebring", "Voyadger"],
			"Mercedes"   => ["C180", "E200", "G500", "S320", "A200", "CLS 350D", "S500", "C200", "E230", "B300"],
			"Cadillac"   => ["Escalade", "DTS", "STS", "CT6", "XT5", "XT4", "XT6", "SRX"],
			"Chevrolet"  => ["Aveo", "Camaro", "Captiva", "Cobalt", "Cruze", "Corvette", "Orlando", "Traverse", "Trailblazer", "Malibu", "Spark"],
			"Volkswagen" => ["Caddy", "Passat", "Golf", "Jetta", "Polo", "Tiquan", "Touareg", "Amarok", "Beetle"],
			"Nissan"     => ["Leaf", "Micra", "Juke", "Qashqai", "GT-R", "Almera", "Murano", "X-Trail", "Tiida", "Pathfinder", "Note", "370Z", "Patrol", "Teana"],
			"Honda"      => ["Civic", "City", "Jazz", "CR-V", "HR-V", "Pilot", "Accord", "Legend"],
			"Mitsubishi" => ["Pajero", "Eclipse", "Grandis", "Outlander", "L200", "Colt", "ASX", "Lancer"],
			"Mazda"      => ["3", "6", "CX-5", "CX-3", "CX-9", "MX-5", "Tribute", "RX-8", "CX-7", "Premacy"],
			"Citroen"    => ["C2", "C3", "C4", "C5 Aircross", "C4 Picasso"],
			"Land Rover" => ["Discovery", "Range Rover", "Defender", "Discovery Sport"],
			"Jeep"       => ["Wrangler", "Cherokee", "Compass", "Renegade", "Grand Cherokee"],
			"Seat"       => ["Ibiza", "Leon", "Leon SP", "Arona", "Ateca", "Tarraco"]];

		$models_to_DB = [];
		$brands = CarBrand::all();

		foreach ($brands as $brand) {
			foreach ($models[$brand->name] as $model) {
				$models_to_DB[] = ["brand_id" => $brand->id, "name" => $model];
			}
		}
		CarModel::insert($models_to_DB);
	}
}
