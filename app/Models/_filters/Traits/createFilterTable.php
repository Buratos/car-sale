<?php

namespace App\Models\_filters\Traits;

use App\Models\_filters\Filter;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

trait createFilterTable {
	// Генерирует код для каждого фильтра. Он используется для передачи отмеченных фильтров через строку GET запроса

	static function createFilterTable() {
		$className = get_called_class();
		$table = $className::$productTable;
		$filterTable = (new $className)->getTable();

//		if (Schema::hasTable($filterTable)) DB::table($filterTable)->truncate();
		Schema::dropIfExists($filterTable);
		Schema::create($filterTable, function (Blueprint $table) {
			$table->id();
			$table->char("type", 2)->default("N");
			$table->string("table", 30);
			$table->string("column", 40);
			$table->string("value", 20)->default("");
			$table->string("code", 12);
			$table->string("belongs_to", 12);
			$table->integer("amount")->default(0);
			$table->string("binded_table_column", 40)->default("");
			$table->string("binded_table_value", 40)->default("");
			$table->string("filter_group_title_on_site", 70)->default("");
			$table->float("min")->default(0);
			$table->float("max")->default(0);
		});

		DB::transaction(function () use ($className, $table, $filterTable) {
			$initialData = DB::table(self::$filtersBasicDataTableName)->where("table", $table)->get()->toArray();
			$allFilters = [];
			$queryArray = [];

			foreach ($initialData as $characteristics) {
				$column = $characteristics->column;
				switch ($characteristics->type) {
					case FILTER_MINI_RANGE :                   //*****************************************
						$titlesMinMax = json_decode($characteristics->titles_min_max);
						foreach ($titlesMinMax as $value => $minMax) {
							$min = $minMax[0];
							$max = $minMax[1];
							$code = self::generateCode();
							$filter = ["type"                       => FILTER_MINI_RANGE,
							           "table"                      => $table,
							           "column"                     => $column,
							           "value"                      => $value,
							           "code"                       => $code,
							           "min"                        => $min,
							           "max"                        => $max,
							           "filter_group_title_on_site" => $characteristics->title_on_site,
							           "binded_table_column"        => "",
							           "binded_table_value"         => "",
							           "belongs_to"                 => ""
							];
							$allFilters[$code] = $filter;
							$queryArray[$code] = self::calculateOneSimpleFilterAmount($filter);
						}
						break;
					case FILTER_RANGE :                   //*****************************************
						$code = self::generateCode();
						$min = DB::table($table)->min($column);
						$max = DB::table($table)->max($column);
						$filter = ["type"                       => FILTER_RANGE,
						           "table"                      => $table,
						           "column"                     => $column,
						           "code"                       => $code,
						           "min"                        => $min,
						           "max"                        => $max,
						           "filter_group_title_on_site" => $characteristics->title_on_site,
						           "binded_table_column"        => "",
						           "binded_table_value"         => "",
						           "value"                      => "",
						           "belongs_to"                 => $characteristics->belongs_to
						];
						$allFilters[$code] = $filter;
						$queryArray[$code] = self::calculateOneSimpleFilterAmount($filter);
						break;
					case FILTER_RELATIONSHIP :               //*****************************************
					case FILTER_COLOR :                      //*****************************************
						$anotherTable = $characteristics->binded_table_name;//Str::plural(Str::before($column, "_id"));
						$anotherColumn = $characteristics->binded_table_column;
						$columnUniqueValues = DB::table($anotherTable)->select($anotherColumn)->distinct()->orderBy($anotherColumn)->pluck($anotherColumn)->toArray();

						$tmpArray = [];
						foreach ($columnUniqueValues as $bindedTableValue) {
							$bindedTableColumn = $characteristics->binded_table_column;

							$belongsToCode = "";
							if ($characteristics->belongs_to) {  // надо для зависимого фильтра найти хозяина, например для модели найти бренд
								$tmp = DB::table($anotherTable)->where($bindedTableColumn, $bindedTableValue)->pluck("id", $characteristics->belongs_to)->toArray();
								$belongsToId = array_keys($tmp)[0];
								$value = $tmp[$belongsToId];
								foreach ($allFilters as $oneFilter) {
									if ($oneFilter["column"] == $characteristics->belongs_to && $oneFilter["value"] == $belongsToId) {
										$belongsToCode = $oneFilter["code"];
										break;
									}
								}
							} else $value = DB::table($anotherTable)->where($bindedTableColumn, $bindedTableValue)->pluck("id")->get(0);

							$code = self::generateCode();
							$filterGroupTitleOnSite = $characteristics->title_on_site;
							$type = ($characteristics->type == FILTER_COLOR) ? FILTER_COLOR : FILTER_RELATIONSHIP;
							$filter = ["type"                       => $type,
							           "table"                      => $table,
							           "column"                     => $column,
							           "value"                      => $value,
							           "code"                       => $code,
							           "binded_table_column"        => $bindedTableColumn,
							           "binded_table_value"         => $bindedTableValue,
							           "filter_group_title_on_site" => $filterGroupTitleOnSite,
							           "min"                        => 0,
							           "max"                        => 0,
							           "belongs_to"                 => $belongsToCode
							];
							$tmpArray[$code] = $filter;
						}
						if ($characteristics->belongs_to) uasort($tmpArray, function ($a, $b) {
							return $a["belongs_to"] <=> $b["belongs_to"];
						});

						$allFilters += $tmpArray;
						foreach ($tmpArray as $code => $filter) $queryArray[$code] = self::calculateOneSimpleFilterAmount($filter);
						//							$allFilters[$code] = $filter;
						break;
					case FILTER_NORMAL_INT :                     //*****************************************
					case FILTER_NORMAL_FLOAT :
					case FILTER_YESNO :
						$columnUniqueValues = DB::table($table)->select($column)->distinct()->orderBy($column)->pluck($column)->toArray();
						foreach ($columnUniqueValues as $value) {
							$type = ($characteristics->type == FILTER_YESNO) ? FILTER_YESNO : FILTER_NORMAL_INT;
							$code = self::generateCode();
							$filterGroupTitleOnSite = $characteristics->title_on_site;
							$filter = ["type"                       => $type,
							           "table"                      => $table,
							           "column"                     => $column,
							           "value"                      => $value,
							           "code"                       => $code,
							           "filter_group_title_on_site" => $filterGroupTitleOnSite,
							           "binded_table_column"        => "",
							           "binded_table_value"         => "",
							           "min"                        => 0,
							           "max"                        => 0,
							           "belongs_to"                 => $characteristics->belongs_to
							];
							$allFilters[$code] = $filter;
							$queryArray[$code] = self::calculateOneSimpleFilterAmount($filter);
						}
						break;
				}
			}

			// исполнить групповой запрос рассчета COUNT
			$summaryQuery = DB::query();
			foreach ($queryArray as $code => $oneQuery) $summaryQuery->selectSub($oneQuery, $code);
			$allAmounts = (array)$summaryQuery->first();
			foreach ($allAmounts as $code => $amount) $allFilters[$code]["amount"] = $amount;

			DB::table($filterTable)->insert($allFilters);
//			$className::insert($allFilters);

			Cache::tags([$filterTable])->flush();
			$filtersFromDB = Cache::tags(["FILTERS", $filterTable])->rememberForever("all", function () use ($className) {
				return $className::all()->toArray();
			});
			return 1;   // 1 - это означает всё прошло успешно
		}, 2);
//		$table = get_called_class()::$productTable;
//		$filterTable = get_called_class()::$filterTable;
		$filterCount = DB::table($filterTable)->count();
		echo "для таблицы <b>$table</b> создано <b>$filterCount</b> фильтров в таблице <b>$filterTable</b><br>";
	}

// ▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪
	static protected function generateCode() {
		static $count = 0;
		if (!$count) $count = mt_rand(100, 200);  // это стартовое значение, исключительно для вида, чтобы было не f1 а f101
		else $count++;
		$code = "f" . $count;
		return $code;
	}

	// ▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪
	static protected function calculateOneSimpleFilterAmount($filter) {
		$query = DB::table(get_called_class()::$productTable);
		switch ($filter["type"]) {
			case FILTER_RELATIONSHIP :
			case FILTER_COLOR :
			case FILTER_NORMAL_INT :
			case FILTER_YESNO :
				$query->where($filter["column"], $filter["value"]);
				break;
			case FILTER_RANGE :
			case FILTER_MINI_RANGE :
				$query->whereBetween($filter["column"], [$filter["min"], $filter["max"]]);
				break;
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

}




