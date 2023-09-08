<?php

namespace App\Http\Controllers\Car;

use App\Http\Controllers\Ssd\BaseController;
use App\Http\Requests\DynamicSearchRequest;
use App\Models\_filters\CarFilter;
use App\Models\_filters\Filter;
use App\Models\Car\Car;

/*********************************************************************
 * вызывается для выдачи корневой страницы
 */

class SearchController extends __BaseController {

	public function __invoke(DynamicSearchRequest $request, CarFilter $filter) {

		$searchStr = $request->validated()["search_str"];
		[$filters, $selectedFilters, $isAnyFiltersSelected, $brands] = $filter->count_Filters_And_Other_Data_From_GETsearchRequest($searchStr);
		[$sortMode, $productsPerPage] = $filter->get_sortMode_perPage_and_setCookie();
		[$compareElems, $favoritesElems] = $this->service->get_Compare_And_Favorites_Lists();
		$cars = $filter->getFilteredContent($selectedFilters, $sortMode, $productsPerPage);
		$pluralWords = Car::getPluralWords();
		$sortModesAndTexts = $filter->getSortModesAndTexts();

		return view("PRODUCTS.Car.search.sections_search", compact(["cars", "sortMode", "productsPerPage", "brands", "filters", "isAnyFiltersSelected", "compareElems", "favoritesElems", "searchStr", "pluralWords","sortModesAndTexts"]));
	}
}
