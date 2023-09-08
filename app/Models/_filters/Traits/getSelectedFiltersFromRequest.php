<?php

namespace App\Models\_filters\Traits;

use App\Models\_filters\Filter;
use Illuminate\Support\Facades\Cache;

trait getSelectedFiltersFromRequest {
	// ▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪
	public static function getSelectedFiltersFromGET($isPostMethod = false) {
		function validateMinMaxParams($min, $max) {
			if ($min < 0 || $min == null) $min = 0;
			if ($max < 0 || $max == null) $max = 0;
			if ($min > $max) {
				$tt = $min;
				$min = $max;
				$max = $tt;
			}
			return [$min, $max];
		}

		//-------------------------------------------------
		// подготовить массив кодов простых фильтров
		if ($isPostMethod) $checkedFilterCodes = request()->checkedFilters ?? [];               // если прислано POST
		else $checkedFilterCodes = ($ff = request()->ff) ? explode("-", $ff) : [];     // если прислано GET

		// теперь диапазонные фильтры
		$diapasonFiltersData = [];
		if ($isPostMethod) {                                                  // если прислано POST
			foreach (request()->diapasonFilters ?? [] as $arr) {
				$minAndMax = validateMinMaxParams($arr[1], $arr[2]);
				if ($minAndMax[1]) $diapasonFiltersData[$arr[0]] = $minAndMax;
			}
		} else if ($fd = request()->fd) {                                      // если прислано GET
			$fd = explode("-", $fd);
			foreach ($fd as $oneDiapasonFilterStr) {
				$arr = explode("_", $oneDiapasonFilterStr);
				$minAndMax = validateMinMaxParams($arr[1], $arr[2]);
				if ($minAndMax[1]) $diapasonFiltersData[$arr[0]] = $minAndMax;
			}
		}

		$checkedFiltersSortedByGroups = convertFilterCodesArrayToGroups($checkedFilterCodes, $diapasonFiltersData);
		$checkedFilterCodes = array_merge($checkedFilterCodes, array_keys($diapasonFiltersData));
		return [$checkedFiltersSortedByGroups, $checkedFilterCodes];
	}

// ▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪
	public static function getSelectedFiltersFromPOST() {
		return self::getSelectedFiltersFromGET(true);
	}

// ▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪
	public static function getSelectedFiltersFromSearchStr($searchStr = "") {
		function isOnlyBrands($brandsAndModelsMixed) {
			$response = true;
			foreach ($brandsAndModelsMixed as $elem)
				if ($elem->column != "brand_id") {
					$response = false;
					break;
				}
			return $response;
		}

		//-------------------------------------------------
		$checkedFilterCodes = [];
		$diapasonFiltersData = [];
		if ($searchStr) {
			$words = str_word_count($searchStr, 1, '1234567890йцукенгшщзхъфывапролджэячсмитьбюёЙЦУКЕНГШЩЗХЪФЫВАПРОЛДЖЭЯЧСМИТЬБЮЁ');
			$brandsAndModelsMixed = collect();
			foreach ($words as $word) {
				$filters = Cache::tags("FILTERS")->remember("searchStr " . $word, 3600, function () use ($word) {
					return CarFilter::whereIn("column", ["brand_id", "model_id"])->where("binded_table_value", "like", "%" . $word . "%")->get();
				});
				$brandsAndModelsMixed = $brandsAndModelsMixed->concat($filters);
			}
			// для найденных брендов надо добавить все модели бренда, а для найденных моделей надо добавить бренд.. А то фильтры отфильтруют всё, т.е. найдено будет 0

			$isOnlyBrands = isOnlyBrands($brandsAndModelsMixed);
			foreach ($brandsAndModelsMixed as $elem) {
				$elems = [];
				if (!$isOnlyBrands && $elem->column == "brand_id") $elems = Cache::tags("FILTERS")->remember("!isOnlyBrands " . $elem->code, 3600, function () use ($elem) {
					return CarFilter::where("belongs_to", $elem->code)->pluck("code")->toArray();
				});
				else $elems[] = $elem->belongs_to;

				$elems[] = $elem->code;
				$checkedFilterCodes = array_merge($checkedFilterCodes, $elems);
			}
			$checkedFilterCodes = collect($checkedFilterCodes)->unique()->sort()->values()->all();
		}
		$checkedFiltersSortedByGroups = convertFilterCodesArrayToGroups($checkedFilterCodes, $diapasonFiltersData);
		$checkedFilterCodes = array_merge($checkedFilterCodes, array_keys($diapasonFiltersData));
		return [$checkedFiltersSortedByGroups, $checkedFilterCodes];
	}

}
