<?php

namespace Database\Seeders\Laptop;

use App\Models\Laptop\LaptopCpu;
use Illuminate\Database\Seeder;

class LaptopCpuSeeder extends Seeder {
	public function run(): void {
		$cpus = ["Intel Core i9-13700H (Raptor Lake)", "Intel Core i9-13900H (Raptor Lake)", "Intel Core i9-13900HX (Raptor Lake)", "Intel Core i9-13700HX (Raptor Lake)", "Intel Core i9-13600H (Raptor Lake)", "Intel Core i9-13500H (Raptor Lake)", "Intel Core i9-1340P (Raptor Lake)", "Intel Core i9-1360P (Raptor Lake)", "Intel Core i7-12900H (Alder Lake)", "Intel Core i7-12800H (Alder Lake)", "Intel Core i7-12700H (Alder Lake)", "Intel Core i7-1240P (Alder Lake)", "Intel Core i7-1260P (Alder Lake)","AMD Ryzen 9 7945HX","AMD Ryzen 9 7940HS","AMD Ryzen 9 7845HX","AMD Ryzen 7 7840HS","AMD Ryzen 7 7840U","AMD Ryzen 7 7745HX","AMD Ryzen 5 7645HX","AMD Ryzen 5 7640HS","AMD Ryzen AMD Ryzen 5 7640U","AMD Ryzen 7 7735HS","AMD Ryzen 7 7735U ","AMD Ryzen 9 6900HX","AMD Ryzen 9 6900HS","AMD Ryzen 7 6800H","AMD Ryzen 7 6800HS","AMD Ryzen 7 6800U","AMD Ryzen 5 6600H","AMD Ryzen 7 Pro 6850U"];
		foreach ($cpus as $cpu) {
			LaptopCpu::insert(["name" => $cpu]);
		}
	}
}

