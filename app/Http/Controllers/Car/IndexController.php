<?php

namespace App\Http\Controllers\Car;

use App\Models\_filters\CarFilter;
use App\Models\Car\Car;

/*********************************************************************
 * вызывается для выдачи корневой страницы
 */
class IndexController extends __BaseController {

	public function __invoke(CarFilter $filter) {
//      TestJob::dispatch("function index __ ЗАДАНИЕ ВЫПОЛНЯЕТСЯ из ОЧЕРЕДИ");

		[$filters, $selectedFilters, $isAnyFiltersSelected, $brands] = $filter->count_Filters_And_Other_Data_From_GET();
		[$sortMode, $productsPerPage] = $filter->get_sortMode_perPage_and_setCookie();
		[$compareElems, $favoritesElems] = $this->service->get_Compare_And_Favorites_Lists();
		$cars = $filter->getFilteredContent($selectedFilters, $sortMode, $productsPerPage);
		$pluralWords = Car::getPluralWords();
		$sortModesAndTexts = $filter->getSortModesAndTexts();
		
		return view("PRODUCTS.Car.index.sections_index", compact(["cars", "sortMode", "productsPerPage", "brands", "filters", "isAnyFiltersSelected", "compareElems", "favoritesElems", "pluralWords","sortModesAndTexts"]));
	}

	// ▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪
}

