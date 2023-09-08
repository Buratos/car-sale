<?php

namespace App\Http\Controllers\Car;

use App\Http\Controllers\Ssd\BaseController;
use App\Models\_filters\CarFilter;
use App\Models\Car\Car;
use App\Models\Car\CarBodyType;
use App\Models\Car\CarBrand;
use App\Models\Car\CarColor;
use App\Models\Car\CarEngineType;
use App\Models\Car\CarGearbox;

/*********************************************************************
 * вызывается для добавления новой машины / в БД
 */
class CreateController extends __BaseController {

	public function __invoke() {
/*		      $user = auth()->user();
					if (is_null(auth()->user())) {
						 abort(403);
					}

		      if (!Gate::allows('create')) {
						 abort(403);
					}
		      if (request()->user()->cannot("create",Car::whereId(1)->first())) {
						 abort(403);
					}

		      $response = Gate::inspect('create');

					if ($response->allowed()) {
						 dd("Действие разрешено ...");
					} else {
						 echo $response->message();
					}
      $this->authorize("create",$user);*/


		[$productsPerPage, $fakeCar, $brands, $models, $gearboxes, $engineTypes, $bodyTypes, $colors] = $this->prepareDataForView();
// fakeCar - the fake car for ease debugging and demonstration

		return view("PRODUCTS.Car.crud.create_car.sections_create_car", compact(["fakeCar", "productsPerPage", "brands", "models", "gearboxes", "engineTypes", "bodyTypes", "colors"]));
	}

	function prepareDataForView() {
		[, $productsPerPage] = CarFilter::get_sortMode_perPage_and_setCookie();

		$fakeCar = Car::factory()->count(1)->make()->get(0);
		$brandsWithModels = CarBrand::with(["modelNames"])->orderBy("name")->get();

		$brands = $brandsWithModels->pluck("name")->toArray();
		foreach ($brandsWithModels as $brand) {
			$models[$brand->name] = $brand->modelNames()->orderBy("name")->pluck("name")->toArray();
		}
		$gearboxes = CarGearbox::pluck("name")->toArray();
		$engineTypes = CarEngineType::pluck("name")->toArray();
		$bodyTypes = CarBodyType::pluck("name")->toArray();
		$colors = CarColor::pluck("name")->toArray();

		return [$productsPerPage, $fakeCar, $brands, $models, $gearboxes, $engineTypes, $bodyTypes, $colors];
	}

}

function flattenCollectionToArray($collection) {
	foreach ($collection as $item) {
		$arr[] = $item->name;
	}
	return $arr;
}