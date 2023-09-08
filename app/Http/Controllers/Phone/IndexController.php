<?php

namespace App\Http\Controllers\Phone;

use App\Models\_filters\PhoneFilter;
use App\Models\Phone\Phone;

/*********************************************************************
 * вызывается для выдачи корневой страницы
 */
class IndexController extends __BaseController {

	public function __invoke(PhoneFilter $filter) {
		[$filters, $selectedFilters, $isAnyFiltersSelected, $brands] = $filter->count_Filters_And_Other_Data_From_GET();
		[$sortMode, $productsPerPage] = $filter->get_sortMode_perPage_and_setCookie();
		[$compareElems, $favoritesElems] = $this->service->get_Compare_And_Favorites_Lists();
		$phones = $filter->getFilteredContent($selectedFilters, $sortMode, $productsPerPage);
		$pluralWords = Phone::getPluralWords();
		$sortModesAndTexts = $filter->getSortModesAndTexts();
		
		return view("PRODUCTS.Phone.index.sections_index", compact(["phones", "sortMode", "productsPerPage", "brands", "filters", "isAnyFiltersSelected", "compareElems", "favoritesElems", "pluralWords","sortModesAndTexts"]));
	}

	// ▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪
}

