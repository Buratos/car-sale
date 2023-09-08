<?php

namespace App\Models\_filters;

use App\Models\_filters\Traits\createFiltersBasicDataTable;
use App\Models\_filters\Traits\createFilterTable;
use App\Models\_filters\Traits\getFilteredContent;
use App\Models\_filters\Traits\getSelectedFiltersFromRequest;
use App\myFN;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

define("FILTER_NORMAL_INT", "Ni");
define("FILTER_NORMAL_FLOAT", "Nf");
define("FILTER_RANGE", "D");
//define("FILTER_RANGE_FLOAT", "Df");
define("FILTER_MINI_RANGE", "MD");
define("FILTER_COLOR", "C");
define("FILTER_YESNO", "YN");
define("FILTER_RELATIONSHIP", "R");

abstract class AbstractFilter extends Model {
	public $timestamps = false;
	protected $guarded = [];
	use HasFactory, createFilterTable, createFiltersBasicDataTable, getFilteredContent, getSelectedFiltersFromRequest;

	protected static $filtersBasicDataTableName = "filters__basic_data";

//             -             -             -             -             -             -
	static function getSortCallback($sortMode) {
		return get_called_class()::$sortCallbacks[$sortMode];
	}

	static function getSortModes() {
		return array_keys(get_called_class()::$sortModesAndTexts);
	}

	public function getSortModesAndTexts() {
		return get_called_class()::$sortModesAndTexts;
	}

	public function count_Filters_And_Other_Data_From_POST() {
		return $this->countFiltersAndOther();
	}

	public function count_Filters_And_Other_Data_From_GET() {
		return $this->countFiltersAndOther();
	}

	public function count_Filters_And_Other_Data_From_GETsearchRequest($searchStr) {
		return $this->countFiltersAndOther($searchStr);
	}

	// ▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪
	protected function countFiltersAndOther($searchStr = "") {
		[$checkedFilters, $checkedFilterCodes, $requestMethod] = $this->getSelectedFiltersFromRequest($searchStr);
		$filters = $this->get_All_Filters_From_DB_And_Sort_Them_Into_Groups();
		$isAnyFiltersSelected = false;

		if ($checkedFilters) {
			$queryArray = [];
			$selectedGroups = $checkedFilters;
			foreach ($selectedGroups as $index => $filterGroup) if (isset($filterGroup["belongs_to"])) unset($selectedGroups[$index]);
			foreach ($filters as $index => $filterGroup) {
				foreach ($filterGroup["codes"] as $index2 => $code) {
					$chiefFilterCode = $filterGroup["belongs_to"][$index2] ?? false;
					$isFilterHidden = $chiefFilterCode ? !in_array($chiefFilterCode, $checkedFilterCodes) : false;
					if ($chiefFilterCode && !$isFilterHidden) $filters[$index]["is_hidden"][$index2] = false;

					if (in_array($code, $checkedFilterCodes) || $isFilterHidden) {   // this is a selected or hidden filter, no need to count
						$filters[$index]["checkedStatuses"][$index2] = $isFilterHidden ? 0 : 1;
						if ($isFilterHidden) $filters[$index]["is_hidden"][$index2] = true;

						$filters[$index]["amounts"][$index2] = "";
						if ($filterGroup["type"] == FILTER_RANGE) {
							$filters[$index]["amounts"] = ["min" => $filters[$index]["values"][0], "max" => $filters[$index]["values"][1]];
							$filters[$index]["values"] = $checkedFilters[$index]["values"];
						}
					} else if ($filterGroup["type"] == FILTER_RANGE) { // this is not a selected filter but Diapason, need to count
						$filtersToCalculate = $selectedGroups;
						$filtersToCalculate[$index]["name"] = $index;
						$filtersToCalculate[$index]["type"] = $filterGroup["type"];
						$filtersToCalculate[$index]["values"] = $filterGroup["values"];
						$filters[$index]["amounts"][$index2] = 0;
					} else {                                // this is not a selected filter, need to count
						$filtersToCalculate = $selectedGroups;
						$filtersToCalculate[$index]["name"] = $index;
						$filtersToCalculate[$index]["type"] = $filterGroup["type"];
						if ($filterGroup["type"] == FILTER_MINI_RANGE) {
							$filtersToCalculate[$index]["minMax"] = [];
							$filtersToCalculate[$index]["minMax"][] = $filterGroup["minMax"][$index2];
						} else {
							$filtersToCalculate[$index]["values"] = [];
							$filtersToCalculate[$index]["values"][] = $filterGroup["values"][$index2];
							$filtersToCalculate[$index]["binded_table_values"] = [];
							$filtersToCalculate[$index]["binded_table_values"][] = $filterGroup["binded_table_values"][$index2];
						}
						$key = "" . $index . "--" . $index2;
						$queryArray[$key] = $this->calculateOneFilterAmount($filtersToCalculate);
					}
				}
			}
			if ($requestMethod != "GET") {
				$summaryQuery = DB::query();
				foreach ($queryArray as $key => $oneQuery) $summaryQuery->selectSub($oneQuery, $key);
				$allNumbers = (array)$summaryQuery->first();

				foreach ($allNumbers as $key => $oneNumber) {
					[$groupIndex, $amountIndex] = explode("--", $key);
					$filters[$groupIndex]["amounts"][$amountIndex] = $oneNumber;
				}
			}
			$selectedItemsTotalCount = array_values((array)$this->calculateOneFilterAmount($checkedFilters)->first())[0];
			$isAnyFiltersSelected = true;
		} else {
			foreach ($filters as $index => $filterGroup) if (isset($filterGroup["belongs_to"])) $filters[$index]["is_hidden"] = array_fill(0, count($filters[$index]["belongs_to"]), true);
			$selectedItemsTotalCount = DB::table(get_called_class()::$productTable)->count();
//			$selectedItemsTotalCount = Car::count();
		}

		if ($requestMethod == "POST") return [$this->convertToCodesAndValuesArray($filters), $selectedItemsTotalCount]; else {
			$codesAndBrands = array_combine($filters["brand_id"]["codes"], $filters["brand_id"]["binded_table_values"]);
			return [$filters, $checkedFilters, /*$selectedItemsTotalCount,*/ $isAnyFiltersSelected, $codesAndBrands];
		}
	}

	// возвращает присланные выбранные фильтры в виде групп, берет их из GET, и из POST
	// или создаёт их из строки поиска $searchStr
	public function getSelectedFiltersFromRequest($searchStr = "") {
		//-------------------------------------------------
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
		function isOnlyBrands($brandsAndModelsMixed) {
			$response = true;
			foreach ($brandsAndModelsMixed as $elem) if ($elem->column != "brand_id") {
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
				$filters = Cache::tags("FILTERS ", get_called_class())->remember("searchStr " . $word, 3600, function () use ($word) {
					return get_called_class()::whereIn("column", ["brand_id", "model_id"])->where("binded_table_value", "like", "%" . $word . "%")->get();
				});
				$brandsAndModelsMixed = $brandsAndModelsMixed->concat($filters);
			}
			// для найденных брендов надо добавить все модели бренда, а для найденных моделей надо добавить бренд.. А то фильтры отфильтруют всё, т.е. найдено будет 0

			$isOnlyBrands = isOnlyBrands($brandsAndModelsMixed);
			foreach ($brandsAndModelsMixed as $elem) {
				$elems = [];
				if (!$isOnlyBrands && $elem->column == "brand_id") $elems = Cache::tags("FILTERS", get_called_class())->remember("!isOnlyBrands " . $elem->code, 3600, function () use ($elem) {
					return get_called_class()::where("belongs_to", $elem->code)->pluck("code")->toArray();
				}); else $elems[] = $elem->belongs_to;
				$elems[] = $elem->code;
				$checkedFilterCodes = array_merge($checkedFilterCodes, $elems);
			}
			$checkedFilterCodes = collect($checkedFilterCodes)->unique()->sort()->values()->all();
			$request_method = "GET";
		} else {
			// подготовить массив кодов простых фильтров
			if (request()->ff) $checkedFilterCodes = explode("-", request()->ff);         // если прислано GET
			if (request()->checkedFilters) $checkedFilterCodes = request()->checkedFilters;  // если прислано POST

			// теперь диапазонные фильтры
			if ($fd = request()->fd) {                                  // если прислано GET
				$fd = explode("-", $fd);
				foreach ($fd as $oneDiapasonFilterStr) {
					$arr = explode("_", $oneDiapasonFilterStr);
					$minAndMax = validateMinMaxParams($arr[1], $arr[2]);
					if ($minAndMax[1]) $diapasonFiltersData[$arr[0]] = $minAndMax;
				}
			}
			if (request()->diapasonFilters) {                            // если прислано POST
				foreach (request()->diapasonFilters as $arr) {
					$minAndMax = validateMinMaxParams($arr[1], $arr[2]);
					if ($minAndMax[1]) $diapasonFiltersData[$arr[0]] = $minAndMax;
				}
			}
			$request_method = request()->methodPOST ? "POST" : "GET";
		}

		$checkedFiltersSortedByGroups = $this->convertFilterCodesArrayToGroups($checkedFilterCodes, $diapasonFiltersData);
		$checkedFilterCodes = array_merge($checkedFilterCodes, array_keys($diapasonFiltersData));
		return [$checkedFiltersSortedByGroups, $checkedFilterCodes, $request_method];
	}

	protected function calculateOneFilterAmount($filters) {
		$query = DB::table(get_called_class()::$productTable);
		foreach ($filters as $filterGroup) {
			switch ($filterGroup["type"]) {
				case FILTER_RANGE :
					$values = $filterGroup["values"];
					$query->whereBetween($filterGroup["name"], $values);
					break;
				case FILTER_MINI_RANGE :
					$query->where(function ($query) use ($filterGroup) {
						foreach ($filterGroup["minMax"] as $index => $minMax) {
							if ($index) $query->orWhereBetween($filterGroup["name"], $minMax); else $query->whereBetween($filterGroup["name"], $minMax);
						}
					});
					break;
				/*	  case FILTER_RELATIONSHIP :
							case FILTER_COLOR :
							case FILTER_NORMAL_INT :
							case FILTER_YESNO :  */
				default:
					$values = $filterGroup["values"];
					$query->whereIn($filterGroup["name"], $values);
					break;
			}
		}
		$query->selectRaw('count(*)');
		return $query;

		// по сути надо из этих запросов собрать один запрос типа:
		// НЕ УДАЛЯТЬ ПРИМЕР НИЖЕ
		/* $allNumbers = (array)DB::query()
			 ->selectSub(DB::table("cars")->whereBetween("id", [10, 70])->selectRaw('count(*)'), 'count1')
			 ->selectSub(DB::table("cars")->where("id", ">", 70)->selectRaw('count(*)'), 'count2')
			 ->selectSub(DB::table("cars")->where("id", ">", 20)->where("production_year", ">", 2015)->selectRaw('count(*)'), 'count3')
						->first();*/
	}

// ▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪
	protected function get_All_Filters_From_DB_And_Sort_Them_Into_Groups() {
		return $this->convertFilterCodesArrayToGroups();
	}

// ▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪
	protected function convertFilterCodesArrayToGroups($checkedFilterCodes = null, $diapasonFilterData = null) {
		$filters = $allCheckedFilterCodes = [];
		$getFromDB = ($checkedFilterCodes === null && $diapasonFilterData === null);
		if ($getFromDB) {
			$filtersFromDB = Cache::tags("FILTERS", get_called_class())->rememberForever("all()->toArray()", function () {
				return get_called_class()::all()->toArray();
			});
		} else {
			// формирую единый массив выбранных фильтров, из БД
			foreach ($checkedFilterCodes as $oneCode) $allCheckedFilterCodes[$oneCode] = 0;
			$allCheckedFilterCodes = $allCheckedFilterCodes + $diapasonFilterData;

			$keys = array_keys($allCheckedFilterCodes);
			$cacheKey = "Filter:" . hash("md4", implode("-", $keys));
			$filtersFromDB = Cache::tags("FILTERS", get_called_class())->rememberForever($cacheKey, function () use ($keys) {
				return get_called_class()::whereIn("code", $keys)->get()->toArray();
			});
		}

		// преобразовываю массив инфы из БД в группы фильтров
		foreach ($filtersFromDB as $oneFilter) {
			$groupName = $oneFilter["column"];
			$filters[$groupName]["name"] = $groupName;
			$filters[$groupName]["type"] = $oneFilter["type"];
			$filters[$groupName]["binded_table_column"] = $oneFilter["binded_table_column"];
			$filters[$groupName]["titleOnSite"] = $oneFilter["filter_group_title_on_site"];
			if ($oneFilter["belongs_to"]) {
//			$filters[$groupName]["belongs_to_name"] = arraySearchByCode($filtersFromDB, $oneFilter["code"]);
				$filters[$groupName]["belongs_to"][] = $oneFilter["belongs_to"];
			}
			switch ($oneFilter["type"]) {
				case FILTER_RANGE :                                      //*********************** Diapason filter
					if ($getFromDB) $filters[$groupName]["values"] = [$oneFilter["min"], $oneFilter["max"]]; else $filters[$groupName]["values"] = $allCheckedFilterCodes[$oneFilter["code"]];
					$filters[$groupName]["totalMin"] = $oneFilter["min"];
					$filters[$groupName]["totalMax"] = $oneFilter["max"];
					break;
				case FILTER_MINI_RANGE :                                      //*********************** Mini Diapason filter
					$filters[$groupName]["values"][] = $oneFilter["value"];
					$filters[$groupName]["binded_table_values"][] = "";
					$filters[$groupName]["minMax"][] = [$oneFilter["min"], $oneFilter["max"]];
					break;
				case FILTER_RELATIONSHIP :                                       //*********************** Relationship / Color filter
				case FILTER_COLOR :
					$filters[$groupName]["values"][] = $oneFilter["value"];
					$filters[$groupName]["binded_table_values"][] = $oneFilter["binded_table_value"];
					break;
				case FILTER_NORMAL_INT :                                        //**************** Normal / YesNo filter
				case FILTER_YESNO :
					$filters[$groupName]["values"][] = $oneFilter["value"];
					$filters[$groupName]["binded_table_values"][] = "";
					break;
			}

			$filters[$groupName]["codes"][] = $oneFilter["code"];
			$filters[$groupName]["amounts"][] = $oneFilter["amount"];
			$filters[$groupName]["checkedStatuses"][] = $getFromDB ? 0 : 1;
		}
		return $filters;
	}

	protected function convertToCodesAndValuesArray($filters) {
		$response = [];
		foreach ($filters as $filterGroup) {
			foreach ($filterGroup["codes"] as $index => $code) {
				if ($filterGroup["type"] == FILTER_RANGE) $response[] = [$code, $filterGroup["values"][0], $filterGroup["values"][1]]; else $response[] = [$code, $filterGroup["amounts"][$index]];
			}
		}
		return $response;
	}

	static function get_sortMode_perPage_and_setCookie() {
		$class = get_called_class();
		[$sortMode, $elementsPerPage] = get_sortMode_perPage($class::$sortModeName, $class::$perPageName, $class::getSortModes());
		myFN::setCookie("sort_mode", 0, 0);
		myFN::setCookie("per_page", 0, 0);
		myFN::setCookie($class::$sortModeName, $sortMode, 15000);
		myFN::setCookie($class::$perPageName, $elementsPerPage, 15000);
		return [$sortMode, $elementsPerPage];
	}
	// ---   the end of the class definition    ---------------------------------------------------
}

// ▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪
// ▪▪▪▪▪▪▪▪▪  вспомогательные функции  ▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪


