<?php

namespace App\Http\Controllers\Car;

use App\Http\Controllers\Ssd\BaseController;

/*********************************************************************
 * удаление записи / машины / row
 */
class DeleteController extends __BaseController {

	public function __invoke() {
//      $this->authorize()
		$this->service->delete(request()->id);
		return response()->redirectToRoute("cars.index");
	}
}
