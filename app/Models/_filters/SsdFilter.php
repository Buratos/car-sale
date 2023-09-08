<?php

namespace App\Models\_filters;

use App\Models\Car\Car;

use App\Models\Ssd\Ssd;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class SsdFilter extends AbstractFilter {
	protected $table = "filters_ssds";
	public $timestamps = false;
	protected $guarded = [];

	static $productTable = "ssds";
	static $productClass = Ssd::class;
	static $sortModeName = "ssds_sort_mode";
	static $perPageName = "ssds_per_page";
// для ****Filter->getFilteredContent()
	static $columnsToSelect = ["id", "brand_id", "model_id", "capacity", "speed_read", "speed_write", "price"];
	static $columnsForWith = ["ssdBrand", "ssdModel"];
	//             -             -             -             -             -             -
	public const BRAND_ASC = 'brand_asc';
	public const BRAND_DESC = 'brand_desc';
	public const CAPACITY_ASC = 'ram_asc';
	public const CAPACITY_DESC = 'ram_desc';
	public const SPEEDREAD_ASC = 'readspeed_asc';
	public const SPEEDREAD_DESC = 'readspeed_desc';
	public const SPEEDWRITE_ASC = 'writespeed_asc';
	public const SPEEDWRITE_DESC = 'writespeed_desc';
	public const PRICE_ASC = 'price_asc';
	public const PRICE_DESC = 'price_desc';
	public const LATEST = 'latest';
	public const OLDEST = 'oldest';
	public const RANDOM = 'random';

	static $sortModesAndTexts = [self::BRAND_ASC       => 'Name ascending',
	                             self::BRAND_DESC      => 'Name descending',
	                             self::CAPACITY_ASC    => 'Capacity ascending',
	                             self::CAPACITY_DESC   => 'Capacity descending',
	                             self::SPEEDREAD_ASC   => 'Read speed ascending',
	                             self::SPEEDREAD_DESC  => 'Read speed descending',
	                             self::SPEEDWRITE_ASC  => 'Write speed ascending',
	                             self::SPEEDWRITE_DESC => 'Write speed descending',
	                             self::PRICE_ASC       => 'Price ascending',
	                             self::PRICE_DESC      => 'Price descending',
	                             self::LATEST          => 'Latest',
	                             self::OLDEST          => 'Oldest',
	                             self::RANDOM          => 'Randomly'];

	static $sortCallbacks = [self::BRAND_ASC       => 'sortBrandAsc',
	                         self::BRAND_DESC      => 'sortBrandDesc',
	                         self::CAPACITY_ASC    => 'sortCapacityAsc',
	                         self::CAPACITY_DESC   => 'sortCapacityDesc',
	                         self::SPEEDREAD_ASC   => 'sortSpeedreadAsc',
	                         self::SPEEDREAD_DESC  => 'sortSpeedreadDesc',
	                         self::SPEEDWRITE_ASC  => 'sortSpeedwriteAsc',
	                         self::SPEEDWRITE_DESC => 'sortSpeedwriteDesc',
	                         self::PRICE_ASC       => 'sortPriceAsc',
	                         self::PRICE_DESC      => 'sortPriceDesc',
	                         self::LATEST          => 'sortLatest',
	                         self::OLDEST          => 'sortOldest',
	                         self::RANDOM          => 'sortRandom'];

//             -             -             -             -             -             -
	static function sortBrandAsc($query) {
		$query->orderBy(SsdBrand::select("name")->whereColumn("ssds_brands.id", "ssds.brand_id"))->orderBy(SsdModel::select("name")->whereColumn("ssds_models.id", "ssds.model_id"));
	}

	static function sortBrandDesc($query) {
		$query->orderByDesc(SsdBrand::select("name")->whereColumn("ssds_brands.id", "ssds.brand_id"))->orderByDesc(SsdModel::select("name")->whereColumn("ssds_models.id", "ssds.model_id"));
	}

	static function sortCapacityAsc($query) {
		$query->orderBy("capacity", "asc");
	}

	static function sortCapacityDesc($query) {
		$query->orderBy("capacity", "desc");
	}

	static function sortSpeedreadAsc($query) {
		$query->orderBy("speed_read", "asc");
	}

	static function sortSpeedreadDesc($query) {
		$query->orderBy("speed_read", "desc");
	}

	static function sortSpeedwriteAsc($query) {
		$query->orderBy("speed_write", "asc");
	}

	static function sortSpeedwriteDesc($query) {
		$query->orderBy("speed_write", "desc");
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
