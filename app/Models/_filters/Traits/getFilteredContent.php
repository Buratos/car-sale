<?php

namespace App\Models\_filters\Traits;


trait getFilteredContent {

	public static function getFilteredContent($filters, $sortMode, $elementsPerPage,) {
		$class = get_called_class();
		$productClass = $class::$productClass;
		$query = $productClass::query();  // Надо именно запрос при помоще модели

		foreach ($filters as $filterGroup) {
			switch ($filterGroup["type"]) {
				case FILTER_RANGE :
					$values = $filterGroup["values"];
					$query->whereBetween($filterGroup["name"], $values);
					break;
				case FILTER_MINI_RANGE :
					$query->where(function ($query) use ($filterGroup) {
						foreach ($filterGroup["minMax"] as $index => $minMax) {
							if ($index) $query->orWhereBetween($filterGroup["name"], $minMax);
							else $query->whereBetween($filterGroup["name"], $minMax);
						}
					});
					break;
				default:
					$values = $filterGroup["values"];
					$query->whereIn($filterGroup["name"], $values);
					break;
			}
		}
		$query = $query->select($class::$columnsToSelect)->with($class::$columnsForWith);

		$callback = $class . "::" . $class::getSortCallback($sortMode);
		call_user_func($callback, $query); // добавляет сортировку
		return $query->paginate($elementsPerPage);

		// НЕ УДАЛЯТЬ КОММЕНТ НИЖЕ
		// по сути надо из этих запросов собрать один запрос типа:
		/* $allNumbers = (array)DB::query()
			 ->selectSub(DB::table("cars")->whereBetween("id", [10, 70])->selectRaw('count(*)'), 'count1')
			 ->selectSub(DB::table("cars")->where("id", ">", 70)->selectRaw('count(*)'), 'count2')
			 ->selectSub(DB::table("cars")->where("id", ">", 20)->where("production_year", ">", 2015)->selectRaw('count(*)'), 'count3')
						->first();*/
	}
}
