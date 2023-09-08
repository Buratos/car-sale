<?php

namespace App\Http\Controllers\Car;

use App\Models\_filters\CarFilter;
use App\Models\Car\Car;
use App\myFN;
use Illuminate\Support\Facades\Redirect;

/*********************************************************************
 * вызывается для выдачи корневой страницы
 */
class LatestController extends __BaseController {

	public function __invoke() {
		myFN::setCookie(CarFilter::$sortModeName, "latest", 15000);
//		return Redirect::route('cars.index');
		return redirect()->route('cars.index');;
//		return response()->redirectToRoute("cars.index");
	}

	// ▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪
}

