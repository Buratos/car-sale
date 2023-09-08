<?php

namespace App\Services;

use App\Models\Car\Car;
use App\Models\VehicleDriveType;

class LaptopService extends __BaseService {
	static $productTable = "laptops";

// ▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪
// searches for dynamic search
	function dynamicSearch($searchStr) {
		$RESULTS_LIMIT = 15;

		$query = search($searchStr)->select(["id", "brand_id", "model_id", "production_year", "price"])->with(["brandName", "modelName"]);
		$numberAdditionallyFound = $query->count();
		$cars = $query->limit($RESULTS_LIMIT)->get();
		$numberAdditionallyFound -= $cars->count();

		// convert found cars to the result array of car->name + car->id
		$foundCars = [];
		foreach ($cars as $car) {
			$title = $car->fullName . "    " . $car->production_year . "       " . number_format($car->price, 0, "", " ") . " $";
			$foundCars[] = ["title" => $title, "id" => $car->id];
		}
		return [collect($foundCars)->sortBy("title"), $numberAdditionallyFound];
	}

	// ▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪
}

// ▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪
//  for dynamic search - parses the query string and returns an Eloquent query
function search($search_str, $limit = 100000) {
	$words = str_word_count($search_str, 1, '1234567890йцукенгшщзхъфывапролджэячсмитьбюёЙЦУКЕНГШЩЗХЪФЫВАПРОЛДЖЭЯЧСМИТЬБЮЁ');
	if (count($words) == 1) {
		if (strlen($words[0]) < 2) return collect();

		$cars = Car::whereHas("brandName", function ($query) use ($words) {
			$query->where("name", "like", "%" . $words[0] . "%");
		})->orWhereHas("modelName", function ($query) use ($words) {
			$query->where("name", "like", "%" . $words[0] . "%");
		})->inRandomOrder();

	} else {  // 2+ words  - 1-brand & 2-model
		$cars = Car::whereHas("brandName", function ($query) use ($words) {
			$query->where("name", "like", "%" . $words[0] . "%");
		})->whereHas("modelName", function ($query) use ($words) {
			$query->where("name", "like", "%" . $words[1] . "%");
		});
	}
	return $cars;
}

