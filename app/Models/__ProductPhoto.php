<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

abstract class __ProductPhoto extends Model {

	static public function correctPhotoIfNnecessary($filenameFrom, $filenameTo = "") {
		$imgProperties = getimagesize($filenameFrom);
		$width = $imgProperties[0];
		$height = $imgProperties[1];
		$type = $imgProperties["mime"];

		if ($width > 4000 || $height > 2500 || $type != "image/webp") {
			$newWidth = $width > 4000 ? 4000 : $width;
			$ratio = $newWidth / $width;
			$newHeight = round($height * $ratio);
			if ($newHeight > 2500) {
				$ratio = 2500 / $newHeight;
				$newHeight = 2500;
				$newWidth = round($newWidth * $ratio);
			}
			if (!$filenameTo) $filenameTo = Str::finish(pathinfo($filenameFrom, PATHINFO_DIRNAME), "/") . pathinfo($filenameFrom, PATHINFO_FILENAME) . "___new.webp";

			$image = Image::make($filenameFrom)->resize($newWidth, $newHeight)->save($filenameTo, 87, 'webp');
			return $filenameTo;
		}
		return "";
	}

	static function makeSmallPhoto($filenameFrom, $filenameTo = "") {
		if ($filenameTo) $to = $filenameTo;
		else $to = Str::finish(pathinfo($filenameFrom, PATHINFO_DIRNAME), "/") . "small_duplicates/" . pathinfo($filenameFrom, PATHINFO_FILENAME) . ".webp";

		$image = Image::make($filenameFrom)->resize(300, null, function ($constraint) { $constraint->aspectRatio(); })->save($to, 90, 'webp');
	}

}
