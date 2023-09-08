<?php

namespace App\Http\Controllers\Car;

use App\Http\Controllers\Ssd\BaseController;
use App\Http\Requests\Car\ExtendedProductCardRequest;
use App\Http\Requests\DynamicSearchRequest;

/*********************************************************************
 * вызывается для выдачи корневой страницы
 */
class GetExtendedProductCardMicroPhotosController extends __BaseController {

	public function __invoke(ExtendedProductCardRequest $request) {
		$id = $request->validated()["id"];
		$photos = $this->service->getDataForExtendedProductCard($id);

		if ($photos) $response = ["success" => 1, "html" => view("components.photos_for_ext_car_card", compact(["photos"]))->render()];
		else $response = ["success" => 0];

		return $response;
	}
}
