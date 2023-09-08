<?php

namespace App\Http\Controllers\Car;


use App\Models\_filters\CarFilter;

class CompareController extends __BaseController {
	public function __invoke() {

		[, $productsPerPage] = CarFilter::get_sortMode_perPage_and_setCookie();
		[$compareElems,] = $this->service->get_Compare_And_Favorites_Lists();
		$cars = $this->service->getCompareContent($compareElems, "brand_asc");
		return view("PRODUCTS.Car.compare.sections_compare", compact(["cars", "productsPerPage", "compareElems"]));
	}
}
