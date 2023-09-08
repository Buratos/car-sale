<?php

namespace App\Http\Controllers\Car;

use App\Http\Controllers\Ssd\BaseController;
use App\Http\Requests\Car\StoreRequest;

/*********************************************************************
 * записывает новую машину в БД, вызывается из добавления новой машины при получении данных через post
 */
class StoreController extends __BaseController {

	public function __invoke(StoreRequest $request) {

		$data = $request->validated();
		$id = $this->service->store($data);
		$response["location"] = route("car.view", ["id" => $id]);
		return $response;
//		return response()->redirectToRoute("car.view",["id" => $car_id]);
	}
}

