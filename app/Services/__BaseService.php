<?php

namespace App\Services;

class __BaseService {

	function get_Compare_And_Favorites_Lists() {
		$compareCookieName = get_called_class()::$productTable . "_compare_elems";
		$favoritesCookieName = get_called_class()::$productTable . "_favorites_elems";
		$compareElems = json_decode($_COOKIE[$compareCookieName] ?? "[]");
		$favoritesElems = json_decode($_COOKIE[$favoritesCookieName] ?? "[]");
		return [$compareElems, $favoritesElems];
	}
}
