<?php

namespace App\Http\Controllers;

use App\Actions\CheckAndReloadMemoryTablesForFiltersCron;
use App\Models\_filters\CarFilter;
use App\Models\_filters\Filter;
use App\Models\_filters\LaptopFilter;
use App\Models\_filters\PhoneFilter;
use App\Models\_filters\SsdFilter;

class FilterController extends Controller {

	public function index(CheckAndReloadMemoryTablesForFiltersCron $memoryTables) {
		echo '<head><title>CREATE FILTERS</title>';
		echo "<link rel='icon' href='" . asset('/img/favicons/favicon_test.png') . "' type='image/x-icon'>";
		echo '</head>';
		create_all_filter_tables();
		$memoryTables->__invoke();
	}

	public function carsCalculateFilters(CarFilter $filter) {
		[$filters, $selectedItemsTotalCount] = $filter->count_Filters_And_Other_Data_From_POST();
		return ["filters" => $filters, "selectedItemsTotalCount" => $selectedItemsTotalCount];
	}

	public function laptopsCalculateFilters(LaptopFilter $filter) {
		[$filters, $selectedItemsTotalCount] = $filter->count_Filters_And_Other_Data_From_POST();
		return ["filters" => $filters, "selectedItemsTotalCount" => $selectedItemsTotalCount];
	}
	public function phonesCalculateFilters(PhoneFilter $filter) {
		[$filters, $selectedItemsTotalCount] = $filter->count_Filters_And_Other_Data_From_POST();
		return ["filters" => $filters, "selectedItemsTotalCount" => $selectedItemsTotalCount];
	}
	public function ssdsCalculateFilters(SsdFilter $filter) {
		[$filters, $selectedItemsTotalCount] = $filter->count_Filters_And_Other_Data_From_POST();
		return ["filters" => $filters, "selectedItemsTotalCount" => $selectedItemsTotalCount];
	}
}
