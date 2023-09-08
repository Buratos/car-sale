<?php

namespace App\Http\Controllers\Car;

use App\Http\Controllers\Ssd\BaseController;
use Storage;

class DeleteUploadedPhotoController extends __BaseController {
	public function __invoke() {
		$fullPath = "temp_photos_" . request()->id_for_link_form_and_uploaded_photos . "/" . request()->filename;
		$disk = "public";
		Storage::disk($disk)->delete($fullPath);
		return ["message" => request()->filename . " DELETED"];

	}
}
