<?php

namespace App\Models\_filters;

use App\Models\Phone\Phone;

class PhoneFilter extends AbstractFilter {
	protected $table = "filters_phones";
	public $timestamps = false;
	protected $guarded = [];

	static $productTable = "phones";
	static $productClass = Phone::class;
	static $sortModeName = "phones_sort_mode";
	static $perPageName = "phones_per_page";
// для ****Filter->getFilteredContent()
	static $columnsToSelect = ["id", "brand_id", "model_id", "display_size", "ram", "storage", "price"];
	static $columnsForWith = ["phoneBrand", "phoneModel"];
	//             -             -             -             -             -             -
	public const BRAND_ASC = 'brand_asc';
	public const BRAND_DESC = 'brand_desc';
	public const RAM_ASC = 'ram_asc';
	public const RAM_DESC = 'ram_desc';
	public const DISPLAYSIZE_ASC = 'displaysize_asc';
	public const DISPLAYSIZE_DESC = 'displaysize_desc';
	public const STORAGE_ASC = 'weight_asc';
	public const STORAGE_DESC = 'weight_desc';
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
	                             self::STORAGE_ASC      => 'Storage ascending',
	                             self::STORAGE_DESC     => 'Storage descending',
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
	                         self::STORAGE_ASC      => 'sortStorageAsc',
	                         self::STORAGE_DESC     => 'sortStorageDesc',
	                         self::PRICE_ASC        => 'sortPriceAsc',
	                         self::PRICE_DESC       => 'sortPriceDesc',
	                         self::LATEST           => 'sortLatest',
	                         self::OLDEST           => 'sortOldest',
	                         self::RANDOM           => 'sortRandom'];

//             -             -             -             -             -             -
	static function sortBrandAsc($query) {
		$query->orderBy(phoneBrand::select("name")->whereColumn("phones_brands.id", "phones.brand_id"))->orderBy(PhoneModel::select("name")->whereColumn("phones_models.id", "phones.model_id"));
	}

	static function sortBrandDesc($query) {
		$query->orderByDesc(PhoneBrand::select("name")->whereColumn("phones_brands.id", "phones.brand_id"))->orderByDesc(PhoneModel::select("name")->whereColumn("phones_models.id", "phones.model_id"));
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

	static function sortStorageAsc($query) {
		$query->orderBy("storage", "asc");
	}

	static function sortStorageDesc($query) {
		$query->orderBy("storage", "desc");
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
