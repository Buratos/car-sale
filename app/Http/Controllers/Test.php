<?php

namespace App\Http\Controllers;

use App\Actions\CheckAndReloadMemoryTablesForFiltersCron;
use App\Http\Requests\DynamicSearchRequest;
use App\Models\_filters\AbstractFilter;
use App\Models\_filters\PhoneFilter;
use App\Models\Car\Car;
use App\Models\Car\CarDescription;
use App\Models\Car\CarPhoto;
use App\Models\Laptop\Laptop;
use App\Models\Phone\Phone;
use App\Models\Ssd\Ssd;
use App\Test\ActionsRunner;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Arr;
use Illuminate\Support\Benchmark;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

// ▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪
class Test extends Controller {

	public function __invoke() {
		$className = "App\Models\_filters\PhoneFilter";
		$filterTable = (new $className)->getTable();
		dump($filterTable);
		return;
	}


// ▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪
// ▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪
	public function postman(DynamicSearchRequest $request) {
		$str = $request->search_str;
		dd(Car::where("description", "like", "%$str%")->select(["brand_id", "model_id", "price"])->toSql());

		return;
		// ▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪
		if (request()->test == 1) return ["success" => 1, "test_str" => "postman прикольный"];
		if (request()->test == 2) return ["success" => 1, "test_str" => "получил 2"];
		else return new JsonResponse([
			"filename" => "11 фигня  2342",
			"message"  => __("There was an unknown problem uploading photo to the server. Please upload your photos again")
		], 551);

	}

	public function __construct() {
		echo '<head><title>TEST</title>';
		echo "<link rel='icon' href='" . asset('/img/favicons/favicon_test.png') . "' type='image/x-icon'>";
		echo '<script src="' . asset('/plugins/jquery-3.7.0.min.js') . '" type="text/javascript"></script>';
		echo '<link href="' . asset('/css/test.css') . '" rel="stylesheet"/>';
		echo '<script src="' . asset('/plugins/live_only_JS_and_css.js') . '" type="text/javascript"></script>';
		echo '<script src="' . asset('/js/test.js') . '" type="text/javascript"></script>';
		echo '</head>';
		return;
		echo '<body><form action="/test_get"><input type="text" name="search_str" val="rel"><input type="submit" id="submit" value="SUBMIT"></form></body>';

		return;
//		cleanPhotosOfGarbage();
//		cleanDiskOf_temp_photos_Garbage(24 * 1);

	}

}
