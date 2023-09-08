<?php

namespace App\Http\Controllers\Car;

use App\Exceptions\ViewCarException;
use App\Http\Controllers\Ssd\BaseController;
use App\Models\_filters\CarFilter;
use App\Models\_filters\Filter;
use App\Models\Car\Car;

/*********************************************************************
 * просмотр записи / машины / row
 */
class ViewController extends __BaseController {

	public function __invoke() {

		$id = request()->id;
		[$productsPerPage, $car, $brandFilterCode] = $this->prepareDataForView($id);

		if (!$car) return response()->redirectToRoute("cars.index");
		return view("PRODUCTS.Car.crud.view_car.sections_view_car", compact(["car", "productsPerPage", "brandFilterCode"]));
	}

	function prepareDataForView($id) {
		try {
			[, $productsPerPage] = CarFilter::get_sortMode_perPage_and_setCookie();
			$car = Car::with(["brandName","modelName","color","bodyType","engineType","gearbox","photos","descriptionBody"])->find($id);
			$brandFilterCode = CarFilter::where("filter_group_title_on_site", "Brand")->where("binded_table_value", $car->Brand)->pluck("code")->first();
		} catch (\Exception $exception) {
			throw new ViewCarException();
		}

		return [$productsPerPage, $car, $brandFilterCode];
	}

}

