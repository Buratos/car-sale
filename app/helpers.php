<?php

use App\Models\_filters\AbstractFilter;
use App\Models\_filters\CarFilter;
use App\Models\_filters\LaptopFilter;
use App\Models\_filters\PhoneFilter;
use App\Models\_filters\SsdFilter;
use App\myFN;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

/*
чтобы добавить в приложение свои хелперы:

- создал файл/файлы типа этого
- добавил его/их пути в файл composer.json:
	    "autoload": {
        "files": ["app/helpers.php"]
      },
- в консоли выполнил команду composer dump
*/

/*
// это от блогера oneCode, может потом буду использовать
if (!function_exists('active_link')) {
	function active_link(string $name, string $active = 'active'): string {
		return Route::is($name) ? $active : '';
	}
}
*/

if (!function_exists('validate')) {
	function validate(array $rules): array {
		return validator(request()->all(), $rules)->validate();
	}
}

/*
 * возвращает параметры sortMode и perPage из GET или COOKIE,
 * а также на всякий случай проверяет, исправляет и записывает в куки исправленное
 */
/*if (!function_exists('get_sortMode_perPage_and_setCookie')) {
	function get_sortMode_perPage_and_setCookie() {
		[$sortMode, $elementsPerPage] = get_sortMode_perPage();
		myFN::setCookie("sort_mode", $sortMode, 15000);
		myFN::setCookie("per_page", $elementsPerPage, 15000);
		return [$sortMode, $elementsPerPage];
	}
}*/

/*
 * возвращает параметры sortMode и perPage из GET или COOKIE
 */
if (!function_exists('get_sortMode_perPage')) {
	function get_sortMode_perPage($sortModeName, $perPageName, $sortModes) {
		$sortMode = request()->sort ?? ($_COOKIE["sort_mode"] ?? "");
		if (!in_array($sortMode, $sortModes)) $sortMode = $_COOKIE[$sortModeName] ?? "random";
		if (!in_array($sortMode, $sortModes)) $sortMode = "random";

		$elementsPerPage = request()->perpage ?? ($_COOKIE["per_page"] ?? "");
		if (!in_array($elementsPerPage, [15, 20, 30, 50, 100])) $elementsPerPage = $_COOKIE[$perPageName] ?? 15;
		if (!in_array($elementsPerPage, [15, 20, 30, 50, 100])) $elementsPerPage = 15;
		return [$sortMode, $elementsPerPage];
	}
}

/*
 * возвращает параметры sortMode и perPage из GET или COOKIE
 */
if (!function_exists('plural_products')) {
	function plural_products($number, $pluralWords) {
		$rus = (app()->getLocale() == "ru");
		if ($rus && $number > 20) $number %= 10;
		switch ($number) {
			case 1 :
				return $pluralWords[0];
			case 2 :
			case 3 :
			case 4 :
				return $pluralWords[1];
			default:
				return $pluralWords[2];
		}
	}
}

/*
 * делит строку на абзацы и помещает каждый из них внутрь тега <p>. И возвращает всё это в виде одной строки
 */
if (!function_exists('convert_to_html_paragraphs')) {
	function convert_to_html_paragraphs($strOrArrayOfStrings) {
		$filter_paragraph = function ($paragraphStr) {
			if (strlen($paragraphStr)) return "<p>$paragraphStr</p>";
			else return "";
		};
		switch (gettype($strOrArrayOfStrings)) {
			case "string" :
				return join(array_map($filter_paragraph, preg_split('~((\r)?\n){2,}~', $strOrArrayOfStrings)));
			case "array" :
				return join(array_map($filter_paragraph, $strOrArrayOfStrings));
			default:
				return $strOrArrayOfStrings;
		}
	}
}

if (!function_exists('set_flag_tableUpdated_in_cache')) {
	function set_flag_tableUpdated_in_cache($model) {
		$tableName = $model->getTable();
		Cache::tags("FILTERS $tableName")->forever("TABLE $tableName UPDATED", 1);
		Log::channel('for_debug')->info("__ProductModel::created() : TABLE $tableName UPDATED");
	}
}

if (!function_exists('create_all_filter_tables')) {
	function create_all_filter_tables() {
		// это только для себя. В реальном проекте таблица должна создаваться из ввода владельца / админа
		AbstractFilter::createFiltersBasicDataTable();

		$filterClasses = [CarFilter::class, LaptopFilter::class, PhoneFilter::class, SsdFilter::class];
		Cache::tags(["FILTERS"])->flush();

		foreach ($filterClasses as $filterClass) {
			$filterClass::createFilterTable();
		}
	}
}

if (!function_exists('move_file_between_disks')) {
	function move_file_between_disks($diskFrom, $filenameFrom, $diskTo, $filenameTo) {
		if (in_array($diskFrom, ["local", "public"]) && in_array($diskTo, ["local", "public"])) {
			$pathFrom = Storage::disk($diskFrom)->path("") . $filenameFrom;
			$pathTo = Storage::disk($diskTo)->path("") . $filenameTo;
			return rename($pathFrom, $pathTo);;
		} else if (in_array($diskFrom, ["local", "public"]) && $diskTo == "S3") {
			$pathFrom = Storage::disk($diskFrom)->path("") . $filenameFrom;
			return Storage::disk($diskTo)->put($filenameTo, file_get_contents($pathFrom));;
		}
		return false;
	}
}
if (!function_exists('get_compare_and_favorites_lists')) {
	function get_compare_and_favorites_lists($productTableName) {
		$compareElems = json_decode($_COOKIE[$productTableName . "_compare_elems"] ?? "[]");
		$favoritesElems = json_decode($_COOKIE[$productTableName . "_favorites_elems"] ?? "[]");
		return [$compareElems, $favoritesElems];
	}
}



/*     НЕ ПОНАДОБИЛАСЬ
if (!function_exists('clear_logs__for_debug')) {
	function clear_logs__for_debug() {
		$logFilePath = storage_path('logs/for_debug.log');
		if (File::exists($logFilePath)) File::put($logFilePath, '');
	}
}
*/
