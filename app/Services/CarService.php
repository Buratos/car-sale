<?php

namespace App\Services;

use App\Services\__BaseService;
use App\Exceptions\NoPhotosException;
use App\Models\Car\CarBodyType;
use App\Models\Car\CarBrand;
use App\Models\Car\Car;
use App\Models\Car\CarColor;
use App\Models\Car\CarDescription;
use App\Models\Car\CarEngineType;
use App\Models\Car\CarGearbox;
use App\Models\Car\CarModel;
use App\Models\Car\CarPhoto;
use App\Models\User;
use App\Models\VehicleDriveType;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use PHPUnit\Logging\Exception;

class CarService extends __BaseService {
	static $productTable = "cars";

	/*	public function getOneCarForView($id) {
			$car = Car::find($id);
	//		$car = Car::whereId($id)->first();
			return $car;
		}*/

	/*	public function getOneCarForEdit($request) {

			$car = Car::whereId($request->id)->first();
			if (!$car) $response = ["error_message" => "No such car found :("];
			else {
				$brand_titles = CarBrand::orderBy("name")->pluck("name", "id");
				$body_type_titles = BodyType::orderBy("name")->pluck("name", "id");

				$car_title = $car->name . " " . $car->production_year;
				$response = ["edit_car_page" => 1, "car" => $car, "car_title" => $car_title, "brand_titles" => $brand_titles, "body_type_titles" => $body_type_titles, "page_title" => "EDIT CAR"];
			}
			return $response;
		}*/

	// ▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪
	public function store($data) {
		global $response;

		DB::transaction(function () use ($data) {
			$photoFilenames = json_decode($data["photo_filenames"]);
			if (!count($photoFilenames)) throw new NoPhotosException();
			global $response;

			$brand_id = CarBrand::where("name", $data["car_brand"])->first()->id;
			$model_id = CarModel::where("name", $data["car_model"])->first()->id;
			$body_type_id = CarBodyType::where("name", $data["car_body_type"])->first()->id;
			$color_id = CarColor::where("name", $data["car_color"])->first()->id;
			$gearbox_id = CarGearbox::where("name", $data["car_gearbox"])->first()->id;
			$engine_type_id = CarEngineType::where("name", $data["car_engine_type"])->first()->id;
			$production_year = $data["car_production_year"];
			$engine_capacity = $data["car_engine_capacity"];
			$engine_power = $data["car_engine_power"];
			$fuel_consumption = $data["car_fuel_consumption"];
			$number_doors = $data["car_number_doors"];
			$number_places = $data["car_number_places"];
			$clearance = $data["car_clearance"];
			$wheelbase = $data["car_wheelbase"];
			$description = $data["car_description"];
			$length = $data["car_length"];
			$width = $data["car_width"];
			$height = $data["car_height"];
			$price = $data["car_price"];
			$mileage = $data["car_mileage"];
			$was_in_accident = $data["car_was_in_accident"];

			$car = User::inRandomOrder()->first()->cars()->create([
				"brand_id"         => $brand_id,
				"model_id"         => $model_id,
				"body_type_id"     => $body_type_id,
				"color_id"         => $color_id,
				"gearbox_id"       => $gearbox_id,
				"engine_type_id"   => $engine_type_id,
				"engine_capacity"  => $engine_capacity,
				"engine_power"     => $engine_power,
				"fuel_consumption" => $fuel_consumption,
				"production_year"  => $production_year,
				"clearance"        => $clearance,
				"wheelbase"        => $wheelbase,
				"number_doors"     => $number_doors,
				"number_places"    => $number_places,
				"length"           => $length,
				"width"            => $width,
				"height"           => $height,
				"mileage"          => $mileage,
				"was_in_accident"  => $was_in_accident,
				"price"            => $price,
				//				"description"      => $description,
			]);

			$id_for_link_form_and_uploaded_photos = $data["id_for_link_form_and_uploaded_photos"];
			$number = 0;
			$photos_to_DB = [];
			foreach ($photoFilenames as $photoFilename) {
				$from = "temp_photos/" . $id_for_link_form_and_uploaded_photos . "/" . $photoFilename;
				$uuidPhotoFilename = (string)Str::uuid() . ".webp";
				$to = "cars_photos/" . $uuidPhotoFilename;

				if (Storage::disk('local')->missing($from)) continue;
				move_file_between_disks("local", $from, "public", $to);
				CarPhoto::makeSmallPhoto(Storage::disk('public')->path("") . $to);
				$number++;
				$photos_to_DB[] = CarPhoto::make(["filename" => $uuidPhotoFilename, "number" => $number, "description" => ""]);
			}
			$emptyTempPhotosFolder = "temp_photos/" . $id_for_link_form_and_uploaded_photos;
			Storage::disk('local')->deleteDirectory($emptyTempPhotosFolder);

			$car->photos()->saveMany($photos_to_DB);
			$car->descriptionBody()->save(CarDescription::make(["text" => $description]));
			if (!$car->id) abort(560, ":(");
			$response = $car->id;
			//			CarCreatedEvent::dispatch($car);
		});
		return $response;
	}

	// ▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪
	public function update($id, $data) {
		global $response;

		DB::transaction(function () use ($id, $data) {
			$photoFilenames = json_decode($data["photo_filenames"], true);
			if (!count($photoFilenames)) throw new NoPhotosException();
			global $response;

			$brand_id = CarBrand::where("name", $data["car_brand"])->first()->id;
			$model_id = CarModel::where("name", $data["car_model"])->first()->id;
			$body_type_id = CarBodyType::where("name", $data["car_body_type"])->first()->id;
			$color_id = CarColor::where("name", $data["car_color"])->first()->id;
			$gearbox_id = CarGearbox::where("name", $data["car_gearbox"])->first()->id;
			$engine_type_id = CarEngineType::where("name", $data["car_engine_type"])->first()->id;
			$production_year = $data["car_production_year"];
			$engine_capacity = $data["car_engine_capacity"];
			$engine_power = $data["car_engine_power"];
			$fuel_consumption = $data["car_fuel_consumption"];
			$number_doors = $data["car_number_doors"];
			$number_places = $data["car_number_places"];
			$clearance = $data["car_clearance"];
			$wheelbase = $data["car_wheelbase"];
			$description = $data["car_description"];
			$length = $data["car_length"];
			$width = $data["car_width"];
			$height = $data["car_height"];
			$price = $data["car_price"];
			$mileage = $data["car_mileage"];
			$was_in_accident = $data["car_was_in_accident"];

			$updated = Car::whereId($id)->update([
				"brand_id"         => $brand_id,
				"model_id"         => $model_id,
				"body_type_id"     => $body_type_id,
				"color_id"         => $color_id,
				"gearbox_id"       => $gearbox_id,
				"engine_type_id"   => $engine_type_id,
				"engine_capacity"  => $engine_capacity,
				"engine_power"     => $engine_power,
				"fuel_consumption" => $fuel_consumption,
				"production_year"  => $production_year,
				"clearance"        => $clearance,
				"wheelbase"        => $wheelbase,
				"number_doors"     => $number_doors,
				"number_places"    => $number_places,
				"length"           => $length,
				"width"            => $width,
				"height"           => $height,
				"mileage"          => $mileage,
				"was_in_accident"  => $was_in_accident,
				"price"            => $price,
			]);
			if (!$updated) throw new Exception("не получилось выполнить car update");;
			$updated = CarDescription::where("car_id", $id)->first()->update(["text" => $description]);
			if (!$updated) throw new Exception("не получилось выполнить car description update");
			$id_for_link_form_and_uploaded_photos = $data["id_for_link_form_and_uploaded_photos"];
			$number = 0;
			$photos_to_DB = [];
			foreach ($photoFilenames as $photoFilename) {
				switch ($photoFilename["status"]) {
					case "old" :
						$number++;
						$photo = CarPhoto::whereFilename($photoFilename["filename"])->first();
						$photo->number = $number;
						$photo->save();
						break;
					case "del" :
						Storage::disk('public')->delete("cars_photos/" . $photoFilename["filename"]);
						Storage::disk('public')->delete("cars_photos/small_duplicates/" . $photoFilename["filename"]);
						$photo = CarPhoto::whereFilename($photoFilename["filename"])->delete();
						break;
					case "new" :
						$from = "temp_photos/" . $id_for_link_form_and_uploaded_photos . "/" . $photoFilename["filename"];
						$uuidPhotoFilename = (string)Str::uuid() . "." . pathinfo($photoFilename["filename"], PATHINFO_EXTENSION);
						$to = "cars_photos/" . $uuidPhotoFilename;
						if (Storage::disk('local')->missing($from) || !move_file_between_disks("local", $from, "public", $to)) break;
						CarPhoto::makeSmallPhoto(Storage::disk('public')->path("") . $to);
						$number++;
						$photos_to_DB[] = CarPhoto::make(["filename" => $uuidPhotoFilename, "number" => $number, "description" => ""]);
						break;
				}
			}
			$emptyTempPhotosFolder = "temp_photos/" . $id_for_link_form_and_uploaded_photos;
			Storage::disk('local')->deleteDirectory($emptyTempPhotosFolder);
			if ($photos_to_DB) {
				$car = Car::find($id);
				$car->photos()->saveMany($photos_to_DB);
			}
		});
		return $id;
	}

// ▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪
	public function delete($id) {
		Car::destroy($id);
	}

// ▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪
	function getFavoriteContent($favoritesElems, $sortMode, $elementsPerPage) {
		if (!$favoritesElems) return Car::where("id", -1)->paginate($elementsPerPage);
		$query = Car::whereIn("id", $favoritesElems)->with(["brandName", "modelName", "photos"]);
		switch ($sortMode) {
			case "brand_asc" :
				$query->orderBy(CarBrand::select("name")->whereColumn("cars_brands.id", "cars.brand_id"))->orderBy(CarModel::select("name")->whereColumn("cars_models.id", "cars.model_id"));
				break;
			case "brand_desc" :
				$query->orderByDesc(CarBrand::select("name")->whereColumn("cars_brands.id", "cars.brand_id"))->orderByDesc(CarModel::select("name")->whereColumn("cars_models.id", "cars.model_id"));
				break;
			case "year_asc" :
				$query->orderBy("production_year", "asc");
				break;
			case "year_desc" :
				$query->orderBy("production_year", "desc");
				break;
			case "price_asc" :
				$query->orderBy("price", "asc");
				break;
			case "price_desc" :
				$query->orderBy("price", "desc");
				break;
			case "latest" :
				$query->orderBy("created_at", "desc");
				break;
			case "oldest" :
				$query->orderBy("created_at", "asc");
				break;
			default:
				$query->inRandomOrder();
		}
		return $query->paginate($elementsPerPage);
	}

// ▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪
/*	function get_Compare_And_Favorites_Lists() {
		$compareElems = json_decode($_COOKIE["cars_compare_elems"] ?? "[]");
		$favoritesElems = json_decode($_COOKIE["cars_favorites_elems"] ?? "[]");
		return [$compareElems, $favoritesElems];
	}*/

// ▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪
	function getCompareContent($compareElems, $sortMode, $limit = 100) {
		if (!$compareElems) return Car::where("id", -1)->get();
		$query = Car::whereIn("id", $compareElems)->with(["brandName", "modelName", "photos", "bodyType", "color", "gearbox", "engineType"]);
		switch ($sortMode) {
			case "brand_asc" :
				$query->orderBy(CarBrand::select("name")->whereColumn("cars_brands.id", "cars.brand_id"))->orderBy(CarModel::select("name")->whereColumn("cars_models.id", "cars.model_id"));
				break;
			case "brand_desc" :
				$query->orderByDesc(CarBrand::select("name")->whereColumn("cars_brands.id", "cars.brand_id"))->orderByDesc(CarModel::select("name")->whereColumn("cars_models.id", "cars.model_id"));
				break;
			case "year_asc" :
				$query->orderBy("production_year", "asc");
				break;
			case "year_desc" :
				$query->orderBy("production_year", "desc");
				break;
			case "price_asc" :
				$query->orderBy("price", "asc");
				break;
			case "price_desc" :
				$query->orderBy("price", "desc");
				break;
			case "latest" :
				$query->orderBy("created_at", "desc");
				break;
			case "oldest" :
				$query->orderBy("created_at", "asc");
				break;
			default:
				$query->inRandomOrder();
		}
		return $query->limit($limit)->get();
	}

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
	public function getDataForExtendedProductCard($id) {
		return CarPhoto::where("car_id", $id)->orderBy("number")->limit(5)->select(["filename"])->get();
	}
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

