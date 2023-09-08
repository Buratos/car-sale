<?php

namespace App\Models\_filters;

use App\Models\Laptop\Laptop;
use App\Models\Laptop\LaptopBrand;
use App\Models\Laptop\LaptopModel;
use Illuminate\Database\Eloquent\Builder;

class LaptopFilter extends AbstractFilter {
	protected $table = "filters_laptops";
	public $timestamps = false;
	protected $guarded = [];

	static $productTable = "laptops";
//	static $filterTable = "filters_laptops";
	static $productClass = Laptop::class;
	static $sortModeName = "laptops_sort_mode";
	static $perPageName = "laptops_per_page";
// для ****Filter->getFilteredContent()
	static $columnsToSelect = ["id", "brand_id", "model_id", "display_size", "ram", "ssd", "price"];
	static $columnsForWith = ["laptopBrand", "laptopModel"/*, "photos"*/];
	//             -             -             -             -             -             -
	public const BRAND_ASC = 'brand_asc';
	public const BRAND_DESC = 'brand_desc';
	public const RAM_ASC = 'ram_asc';
	public const RAM_DESC = 'ram_desc';
	public const DISPLAYSIZE_ASC = 'displaysize_asc';
	public const DISPLAYSIZE_DESC = 'displaysize_desc';
	public const WEIGHT_ASC = 'weight_asc';
	public const WEIGHT_DESC = 'weight_desc';
	public const PRICE_ASC = 'price_asc';
	public const PRICE_DESC = 'price_desc';
	public const LATEST = 'latest';
	public const OLDEST = 'oldest';
	public const RANDOM = 'random';

	static $sortModesAndTexts = [self::BRAND_ASC        => 'Name ascending',
	                             self::BRAND_DESC       => 'Name descending',
	                             self::RAM_ASC          => 'RAM ascending',
	                             self::RAM_DESC         => 'RAM descending',
	                             self::DISPLAYSIZE_ASC  => 'Display size ascending',
	                             self::DISPLAYSIZE_DESC => 'Display size descending',
	                             self::WEIGHT_ASC       => 'Weight ascending',
	                             self::WEIGHT_DESC      => 'Weight descending',
	                             self::PRICE_ASC        => 'Price ascending',
	                             self::PRICE_DESC       => 'Price descending',
	                             self::LATEST           => 'Latest',
	                             self::OLDEST           => 'Oldest',
	                             self::RANDOM           => 'Randomly'];

	static $sortCallbacks = [self::BRAND_ASC        => 'sortBrandAsc',
	                         self::BRAND_DESC       => 'sortBrandDesc',
	                         self::RAM_ASC          => 'sortRamAsc',
	                         self::RAM_DESC         => 'sortRamDesc',
	                         self::DISPLAYSIZE_ASC  => 'sortDisplaysizeAsc',
	                         self::DISPLAYSIZE_DESC => 'sortDisplaysizeDesc',
	                         self::WEIGHT_ASC       => 'sortWeightAsc',
	                         self::WEIGHT_DESC      => 'sortWeightDesc',
	                         self::PRICE_ASC        => 'sortPriceAsc',
	                         self::PRICE_DESC       => 'sortPriceDesc',
	                         self::LATEST           => 'sortLatest',
	                         self::OLDEST           => 'sortOldest',
	                         self::RANDOM           => 'sortRandom'];

//             -             -             -             -             -             -
	static function sortBrandAsc($query) {
		$query->orderBy(LaptopBrand::select("name")->whereColumn("laptops_brands.id", "laptops.brand_id"))->orderBy(LaptopModel::select("name")->whereColumn("laptops_models.id", "laptops.model_id"));
	}

	static function sortBrandDesc($query) {
		$query->orderByDesc(LaptopBrand::select("name")->whereColumn("laptops_brands.id", "laptops.brand_id"))->orderByDesc(LaptopModel::select("name")->whereColumn("laptops_models.id", "laptops.model_id"));
	}

	static function sortRamAsc($query) {
		$query->orderBy("ram", "asc");
	}

	static function sortRamDesc($query) {
		$query->orderBy("ram", "desc");
	}

	static function sortDisplaysizeAsc($query) {
		$query->orderBy("display_size", "asc");
	}

	static function sortDisplaysizeDesc($query) {
		$query->orderBy("display_size", "desc");
	}

	static function sortWeightAsc($query) {
		$query->orderBy("weight", "asc");
	}

	static function sortWeightDesc($query) {
		$query->orderBy("weight", "desc");
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


