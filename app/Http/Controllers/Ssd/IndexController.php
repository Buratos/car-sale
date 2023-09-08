<?php

namespace App\Http\Controllers\Ssd;

use App\Http\Controllers\Laptop\__BaseController;
use App\Models\_filters\SsdFilter;
use App\Models\Ssd\Ssd;

/*********************************************************************
 * вызывается для выдачи корневой страницы
 */
class IndexController extends __BaseController {

	public function __invoke(SsdFilter $filter) {
		[$filters, $selectedFilters, $isAnyFiltersSelected, $brands] = $filter->count_Filters_And_Other_Data_From_GET();
		[$sortMode, $productsPerPage] = $filter->get_sortMode_perPage_and_setCookie();
		[$compareElems, $favoritesElems] = $this->service->get_Compare_And_Favorites_Lists();
		$ssds = $filter->getFilteredContent($selectedFilters, $sortMode, $productsPerPage);
		$pluralWords = Ssd::getPluralWords();
		$sortModesAndTexts = $filter->getSortModesAndTexts();

		return view("PRODUCTS.Ssd.index.sections_index", compact(["ssds", "sortMode", "productsPerPage", "brands", "filters", "isAnyFiltersSelected", "compareElems", "favoritesElems", "pluralWords", "sortModesAndTexts"]));
	}

	// ▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪
}

