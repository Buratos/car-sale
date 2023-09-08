<?php

namespace App\Http\Controllers\Car;

use App\Http\Controllers\Ssd\BaseController;
use App\Models\_filters\CarFilter;

class FavoritesController extends __BaseController {
	public function __invoke() {
		[$sortMode, $productsPerPage] = CarFilter::get_sortMode_perPage_and_setCookie();
		[$compareElems, $favoritesElems] = $this->service->get_Compare_And_Favorites_Lists();
		$cars = $this->service->getFavoriteContent($favoritesElems,$sortMode, $productsPerPage);

		return view("PRODUCTS.Car.favorites.sections_favorites", compact(["cars", "sortMode", "productsPerPage", "compareElems", "favoritesElems"]));
	}
}
