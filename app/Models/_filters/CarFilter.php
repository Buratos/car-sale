<?php

namespace App\Models\_filters;

use App\Models\Car\Car;

use App\Models\Car\CarBrand;
use App\Models\Car\CarModel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class CarFilter extends AbstractFilter {
	protected $table = "filters_cars";
	public $timestamps = false;
	protected $guarded = [];

	static $productTable = "cars";
	static $productClass = Car::class;
	static $sortModeName = "cars_sort_mode";
	static $perPageName = "cars_per_page";
// для ****Filter->getFilteredContent()
	static $columnsToSelect = ["id", "brand_id", "model_id", "production_year", "mileage", "price"];
	static $columnsForWith = ["brandName", "modelName", "photos"];
	//             -             -             -             -             -
	public const BRAND_ASC = 'brand_asc';
	public const BRAND_DESC = 'brand_desc';
	public const YEAR_ASC = 'year_asc';
	public const YEAR_DESC = 'year_desc';
	public const PRICE_ASC = 'price_asc';
	public const PRICE_DESC = 'price_desc';
	public const LATEST = 'latest';
	public const OLDEST = 'oldest';
	public const RANDOM = 'random';

	static $sortModesAndTexts = [self::BRAND_ASC  => 'Name ascending',
	                             self::BRAND_DESC => 'Name descending',
	                             self::YEAR_ASC   => 'Year ascending',
	                             self::YEAR_DESC  => 'Year descending',
	                             self::PRICE_ASC  => 'Price ascending',
	                             self::PRICE_DESC => 'Price descending',
	                             self::LATEST     => 'Latest',
	                             self::OLDEST     => 'Oldest',
	                             self::RANDOM     => 'Randomly'];

	static $sortCallbacks = [self::BRAND_ASC  => 'sortBrandAsc',
	                         self::BRAND_DESC => 'sortBrandDesc',
	                         self::YEAR_ASC   => 'sortYearAsc',
	                         self::YEAR_DESC  => 'sortYearDesc',
	                         self::PRICE_ASC  => 'sortPriceAsc',
	                         self::PRICE_DESC => 'sortPriceDesc',
	                         self::LATEST     => 'sortLatest',
	                         self::OLDEST     => 'sortOldest',
	                         self::RANDOM     => 'sortRandom'];

//             -             -             -             -             -             -

	static function sortBrandAsc($query) {
		$query->orderBy(CarBrand::select("name")->whereColumn("cars_brands.id", "cars.brand_id"))->orderBy(CarModel::select("name")->whereColumn("cars_models.id", "cars.model_id"));
	}

	static function sortBrandDesc($query) {
		$query->orderByDesc(CarBrand::select("name")->whereColumn("cars_brands.id", "cars.brand_id"))->orderByDesc(CarModel::select("name")->whereColumn("cars_models.id", "cars.model_id"));
	}

	static function sortYearAsc($query) {
		$query->orderBy("production_year", "asc");
	}

	static function sortYearDesc($query) {
		$query->orderBy("production_year", "desc");
	}

	static function sortPriceAsc($query) {
		$query->orderBy("price", "asc");
	}

	static function sortPriceDesc($query) {
		$query->orderBy("price", "desc");
	}

	static function sortLatest($query) {
		$query->orderBy("created_at", "desc");
	}

	static function sortOldest($query) {
		$query->orderBy("created_at", "asc");
	}

	static function sortRandom($query) {
		$query->inRandomOrder();
	}

	// ---   the end of the class definition    ---------------------------------------------------
}
