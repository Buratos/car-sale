<?php

namespace App\Http\Controllers\Car;

use App\Http\Controllers\Ssd\BaseController;
use App\Http\Requests\Car\StoreRequest;

/*********************************************************************
 * редактирование записи / машины / row
 */
class UpdateController extends __BaseController {

	public function __invoke(StoreRequest $request) {
		$data = $request->validated();
		$id = $this->service->update($request->id, $data);
		$response["location"] = route("car.view", ["id" => $id]);

		return $response;
	}
}
