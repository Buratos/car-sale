<?php

namespace Database\Seeders;

use App\Actions\CheckAndReloadMemoryTablesForFiltersCron;
use App\Models\Car\Car;
use App\Models\Car\CarDescription;
use App\Models\Car\CarPhoto;
use Database\Seeders\Car\BodyTypeSeeder;
use Database\Seeders\Car\BrandNameSeeder;
use Database\Seeders\Car\ColorSeeder;
use Database\Seeders\Car\EngineTypeSeeder;
use Database\Seeders\Car\GearboxSeeder;
use Database\Seeders\Car\ModelNameSeeder;
use Database\Seeders\Laptop\LaptopBrandSeeder;
use Database\Seeders\Laptop\LaptopCpuSeeder;
use Database\Seeders\Laptop\LaptopDisplayResolutionSeeder;
use Database\Seeders\Laptop\LaptopGraphicsCardSeeder;
use Database\Seeders\Laptop\LaptopModelSeeder;
use Database\Seeders\Laptop\LaptopSeeder;
use Database\Seeders\Phone\PhoneBrandSeeder;
use Database\Seeders\Phone\PhoneChipsetSeeder;
use Database\Seeders\Phone\PhoneModelSeeder;
use Database\Seeders\Phone\PhoneSeeder;
use Database\Seeders\Ssd\SsdBrandSeeder;
use Database\Seeders\Ssd\SsdInterfaceSeeder;
use Database\Seeders\Ssd\SsdModelSeeder;
use Database\Seeders\Ssd\SsdSeeder;
use Database\Seeders\test\MemoryTableRowSeeder;
use Database\Seeders\test\TableRowSeeder;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder {
	/**
	 * Seed the application's database.
	 *
	 * @return void
	 */

	public function run() {

		$this->call([ProductCategorySeeder::class, LaptopBrandSeeder::class, LaptopModelSeeder::class, LaptopCpuSeeder::class, LaptopDisplayResolutionSeeder::class, LaptopGraphicsCardSeeder::class, LaptopSeeder::class, PhoneBrandSeeder::class, PhoneChipsetSeeder::class, PhoneModelSeeder::class, PhoneSeeder::class, SsdBrandSeeder::class, SsdModelSeeder::class, SsdInterfaceSeeder::class, SsdSeeder::class]);

		$this->call([BodyTypeSeeder::class, BrandNameSeeder::class, ModelNameSeeder::class, ColorSeeder::class, EngineTypeSeeder::class, GearboxSeeder::class, UserSeeder::class /*, TestSeeder::class*/]);

		// создаю набор фоток
		Storage::disk('public')->deleteDirectory("cars_photos");
		mkdir("storage/app/public/cars_photos/", 0777, true);
		mkdir("storage/app/public/cars_photos/small_duplicates/", 0777, true);

		$photos = [];
		$dir = scandir("resources/__cars_photos_sources/cars_photos/");
		foreach ($dir as $brandName) {
			if (in_array($brandName, [".", ".."])) continue;
			$dir_level2 = scandir("resources/__cars_photos_sources/cars_photos/" . $brandName);
			foreach ($dir_level2 as $photoFilenameInput) {
				if (in_array($photoFilenameInput, [".", ".."])) continue;
				$filenameOutput = (string)Str::uuid() . "." . pathinfo($photoFilenameInput, PATHINFO_EXTENSION);
				$from = "resources/__cars_photos_sources/cars_photos/" . $brandName . "/";
				$to = "storage/app/public/cars_photos/";
				if (copy($from . $photoFilenameInput, $to . $filenameOutput)) $photos[$brandName][] = $filenameOutput;
				CarPhoto::makeSmallPhoto($to . $filenameOutput);
				$photos[$brandName][] = $filenameOutput;
			}
		}

		// для каждой машины надо добавить фотки
		foreach (Car::lazy(50000) as $car) {
			$photosToDB = [];
			$brand = strtolower($car->brand);
			$numberPhotosForCar = mt_rand(10, 20);
			$photosNames = Arr::shuffle(Arr::random($photos[$brand], $numberPhotosForCar));
			for ($i = 0; $i < count($photosNames); $i++) {
				$description = fake()->text(mt_rand(60, 75));
				$photosToDB[] = CarPhoto::make(["filename" => $photosNames[$i], "number" => $i + 1, "description" => $description]);
			}
			$car->photos()->saveMany($photosToDB);
			$car->descriptionBody()->save(CarDescription::factory()->make());
		}
		//сгенерить всё необходимое для работы фильтров
		create_all_filter_tables();
		$memoryTables = new CheckAndReloadMemoryTablesForFiltersCron;
		$memoryTables->__invoke();
	}
}