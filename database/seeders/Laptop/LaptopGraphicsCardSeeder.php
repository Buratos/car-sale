<?php

namespace Database\Seeders\Laptop;

use App\Models\Laptop\LaptopGraphicsCard;
use Illuminate\Database\Seeder;

class LaptopGraphicsCardSeeder extends Seeder {
	public function run(): void {
		$gpus = ["NVIDIA GeForce RTX 4090", "NVIDIA GeForce RTX 4080", "NVIDIA GeForce RTX 4070", "NVIDIA GeForce RTX 4060", "NVIDIA GeForce RTX 4050", "NVIDIA GeForce RTX 3080", "NVIDIA GeForce RTX 3070", "NVIDIA GeForce RTX 3060", "NVIDIA GeForce RTX 3050", "NVIDIA GeForce MX550/MX570", "AMD Radeon RX 7600S", "AMD Radeon RX 6800S","AMD Radeon RX 6800M", "AMD Radeon RX 6700S","AMD Radeon RX 6700M","AMD Radeon RX 6600M","AMD Radeon 780M","AMD Radeon 760M","AMD Radeon 680M","AMD Radeon 660M","Intel Arc 770M","Intel Iris Xe Graphics"];
		foreach ($gpus as $gpu) {
			LaptopGraphicsCard::insert(["name" => $gpu]);
		}
	}
}
