<?php

namespace App\Http\Controllers\Car;

use App\Http\Controllers\Ssd\BaseController;
use App\Http\Requests\DynamicSearchRequest;

/*********************************************************************
 * вызывается для выдачи корневой страницы
 */
class DynamicSearchController extends __BaseController {

	public function __invoke(DynamicSearchRequest $request) {
		$searchStr = $request->validated()["search_str"];
		[$foundCars, $numberAdditionallyFound] = $this->service->dynamicSearch($searchStr);

		if (count($foundCars) > 0) $response = ["success" => 1, "html" => view("PRODUCTS.Car.search.dynamic_search_list_item", compact(["foundCars","numberAdditionallyFound","searchStr"]))->render()];
		else $response = ["success" => 0];

		return $response;
	}
}
