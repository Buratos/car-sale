<?php

namespace App\Models\_filters\Traits;

use App\Models\_filters\Filter;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

trait createFiltersBasicDataTable {

// ▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪
// Эта таблица  должна создаваться через веб-интерфейс из ввода админа/владельца
// фактически это таблица для создания / удаления / редактирования фильтров - брэнд, цвет, процессор, размер памяти, цена
// Но я не буду создавать веб интерфейс, а просто сгенерю её из массива
	static function createFiltersBasicDataTable() {
		define("__TYPE__", 0);
		define("__TITLE_ON_SITE__", 1);
		define("__BINDED_TABLE_NAME__", 2);
		define("__BINDED_TABLE_COLUMN__", 3);
		define("__BELONGS_TO__", 4);
		define("__MINMAX__", "titlesMinMax");

		$initialData =
			["cars"    => ["brand_id"         => [FILTER_RELATIONSHIP, "Brand", "cars_brands", "name"],
			               "model_id"         => [FILTER_RELATIONSHIP, "Model", "cars_models", "name", "brand_id"],
			               "body_type_id"     => [FILTER_RELATIONSHIP, "Body type", "cars_body_types", "name"],
			               "color_id"         => [FILTER_COLOR, "Color", "cars_colors", "name"],
			               "gearbox_id"       => [FILTER_RELATIONSHIP, "Gearbox", "cars_gearboxes", "name"],
			               "engine_type_id"   => [FILTER_RELATIONSHIP, "Engine type", "cars_engine_types", "name"],
			               "engine_capacity"  => [FILTER_NORMAL_INT, "Engine capacity"],
			               "engine_power"     => [FILTER_MINI_RANGE, "Engine power", "titlesMinMax" =>
				               ["< 70" => [0, 69], "70 - 89" => [70, 89], "90 - 119" => [90, 119], "120 - 149" => [120, 149], "150 - 199" => [150, 199], "200 - 249" => [200, 249], "> 250" => [250, 2000]]],
			               "fuel_consumption" => [FILTER_MINI_RANGE, "Mixed fuel consumption", "titlesMinMax" =>
				               ["4 - 4.9" => [4, 4.99], "5 - 5.9" => [5, 5.99], "6 - 6.9" => [6, 6.99], "7 - 7.9" => [7, 7.99], "8 - 8.9" => [8, 8.99], "9 - 9.9" => [9, 9.99], "10 - 12" => [10, 12], "> 12" => [12.01, 50]]],
			               "production_year"  => [FILTER_NORMAL_INT, "Production year"],
			               "clearance"        => [FILTER_RANGE, "Ground clearance"],
			               "wheelbase"        => [FILTER_RANGE, "Wheelbase"],
			               "number_doors"     => [FILTER_NORMAL_INT, "Number of doors"],
			               "number_places"    => [FILTER_NORMAL_INT, "Number of places"],
			               "length"           => [FILTER_RANGE, "Length"],
			               "width"            => [FILTER_RANGE, "Width"],
			               "height"           => [FILTER_RANGE, "Height"],
			               "mileage"          => [FILTER_RANGE, "Mileage"],
			               "was_in_accident"  => [FILTER_YESNO, "Was in accident"],
			               "price"            => [FILTER_RANGE, "Price"]],
			 "laptops" => ["brand_id"              => [FILTER_RELATIONSHIP, "Brand", "laptops_brands", "name"],
			               "model_id"              => [FILTER_RELATIONSHIP, "Model", "laptops_models", "name", "brand_id"],
			               "cpu_id"                => [FILTER_RELATIONSHIP, "CPU", "laptops_cpus", "name"],
			               "graphics_card_id"      => [FILTER_RELATIONSHIP, "Graphics card", "laptops_graphics_cards", "name"],
			               "ram"                   => [FILTER_NORMAL_INT, "RAM"],
			               "ssd"                   => [FILTER_NORMAL_INT, "SSD"],
			               "display_size"          => [FILTER_NORMAL_FLOAT, "Display size"],
			               "display_resolution_id" => [FILTER_RELATIONSHIP, "Display resolution", "laptops_display_resolutions", "name"],
			               "weight"                => [FILTER_MINI_RANGE, "Weight", "titlesMinMax" =>
				               ["< 1000" => [0, 999], "1000 - 1500" => [1000, 1500], "1501 - 1900" => [1501, 1900], "1901 - 2100" => [1901, 2100], "2101 - 2300" => [2101, 2300], "2301 - 2500" => [2301, 2500], "2501 - 2700" => [2501, 2700], "2701 - 3000" => [2701, 3000], "> 3000" => [3001, 10000]]],
			               "price"                 => [FILTER_RANGE, "Price"]],
			 "phones"  => ["brand_id"     => [FILTER_RELATIONSHIP, "Brand", "phones_brands", "name"],
			               "model_id"     => [FILTER_RELATIONSHIP, "Model", "phones_models", "name", "brand_id"],
			               "chipset_id"   => [FILTER_RELATIONSHIP, "CPU", "phones_chipsets", "name"],
			               "ram"          => [FILTER_NORMAL_INT, "RAM"],
			               "storage"      => [FILTER_NORMAL_INT, "Storage"],
			               "display_size" => [FILTER_NORMAL_FLOAT, "Screen size"],
			               "camera"       => [FILTER_NORMAL_INT, "Camera"],
			               "weight"       => [FILTER_MINI_RANGE, "Weight", "titlesMinMax" =>
				               ["< 170" => [0, 169], "170 - 180" => [170, 180], "181 - 190" => [181, 190], "191 - 200" => [191, 200], "201 - 210" => [201, 210], "211 - 220" => [211, 220], "> 220" => [221, 10000]]],
			               "price"        => [FILTER_RANGE, "Price"]],
			 "ssds"    => ["brand_id"     => [FILTER_RELATIONSHIP, "Brand", "ssds_brands", "name"],
			               "model_id"     => [FILTER_RELATIONSHIP, "Model", "ssds_models", "name", "brand_id"],
			               "interface_id" => [FILTER_RELATIONSHIP, "Interface", "ssds_interfaces", "name"],
			               "type"         => [FILTER_NORMAL_INT, "SSD type"],
			               "capacity"     => [FILTER_NORMAL_INT, "Capacity, Gb"],
			               "speed_read"   => [FILTER_MINI_RANGE, "Read speed, Mb", "titlesMinMax" =>
				               ["< 1000" => [0, 999], "1000 - 1500" => [1000, 1500], "1501 - 2000" => [1501, 2000], "2001 - 3000" => [2001, 3000], "3001 - 4000" => [3001, 4000], "4001 - 5000" => [4001, 5000], "5001 - 6000" => [5001, 6000], "6001 - 7000" => [6001, 7000], "7001 - 8000" => [7001, 8000], "8001 - 10000" => [8001, 10000], "> 10000" => [10001, 100000]]],
			               "speed_write"  => [FILTER_MINI_RANGE, "Write speed, Mb", "titlesMinMax" =>
				               ["< 1000" => [0, 999], "1000 - 1500" => [1000, 1500], "1501 - 2000" => [1501, 2000], "2001 - 3000" => [2001, 3000], "3001 - 4000" => [3001, 4000], "4001 - 5000" => [4001, 5000], "5001 - 6000" => [5001, 6000], "6001 - 7000" => [6001, 7000], "7001 - 8000" => [7001, 8000], "8001 - 10000" => [8001, 10000], "> 10000" => [10001, 100000]]],
			               "price"        => [FILTER_RANGE, "Price"]]];

		if (Schema::hasTable(self::$filtersBasicDataTableName)) DB::table(self::$filtersBasicDataTableName)->truncate();
		else Schema::create(self::$filtersBasicDataTableName, function (Blueprint $table) {
			$table->id();
			$table->string("table", 30);
			$table->string("column", 40);
			$table->char("type", 2)->default(FILTER_NORMAL_INT);
			$table->string("title_on_site", 70)->default("");
			$table->string("binded_table_name", 40)->default("");
			$table->string("binded_table_column", 40)->default("");
			$table->string("belongs_to", 40)->default("");
			$table->text("titles_min_max");
		});

		foreach ($initialData as $tableName => $filterCategories) {
			foreach ($filterCategories as $categoryName => $categoryParams)
				DB::table(self::$filtersBasicDataTableName)->insert([
					'table'               => $tableName,
					'column'              => $categoryName,
					'type'                => $categoryParams[__TYPE__],
					'title_on_site'       => $categoryParams[__TITLE_ON_SITE__],
					'binded_table_name'   => $categoryParams[__BINDED_TABLE_NAME__] ?? "",
					'binded_table_column' => $categoryParams[__BINDED_TABLE_COLUMN__] ?? "",
					'belongs_to'          => $categoryParams[__BELONGS_TO__] ?? "",
					'titles_min_max'      => isset($categoryParams[__MINMAX__]) ? json_encode($categoryParams[__MINMAX__]) : ""]);
		}
	}

}




