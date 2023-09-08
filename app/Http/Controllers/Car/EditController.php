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
 * просмотр записи / машины / row
 */
class EditController extends __BaseController {

	public function __invoke() {
		/*      $user = auth()->user();
					if (is_null(auth()->user())) {
						 dd("ПУСТОЙ юзер");
						 abort(403);
					} elseif (auth()->user()->id != request()->id) {
						 dd("НЕ АДМИН");
					}
		*/

		$id = request()->id;
		[$productsPerPage, $car, $brands, $models, $gearboxes, $engineTypes, $bodyTypes, $colors] = $this->prepareDataForView($id);

		return view("PRODUCTS.Car.crud.edit_car.sections_edit_car", compact(["car", "productsPerPage", "brands", "models", "gearboxes", "engineTypes", "bodyTypes", "colors"]));

/*		[, $productsPerPage] = get_sortMode_perPage_and_setCookie();
		$car = $this->service->getOneCarForView();
		return view("PRODUCTS.Car.crud.view_car.sections_view_car", compact(["car", "productsPerPage"]));*/
	}

	function prepareDataForView($id) {
		[, $productsPerPage] = CarFilter::get_sortMode_perPage_and_setCookie();

		$car = Car::find($id);
		$brandsWithModels = CarBrand::with(["modelNames"])->orderBy("name")->get();

		$brands = $brandsWithModels->pluck("name")->toArray();
		foreach ($brandsWithModels as $brand) {
			$models[$brand->name] = $brand->modelNames()->orderBy("name")->pluck("name")->toArray();
		}
		$gearboxes = CarGearbox::pluck("name")->toArray();
		$engineTypes = CarEngineType::pluck("name")->toArray();
		$bodyTypes = CarBodyType::pluck("name")->toArray();
		$colors = CarColor::pluck("name")->toArray();

		return [$productsPerPage, $car, $brands, $models, $gearboxes, $engineTypes, $bodyTypes, $colors];
	}

}

