<?php

namespace App\Http\Controllers\Car;

use App\Exceptions\PhotoUploadException;
use App\Http\Controllers\Ssd\BaseController;
use App\Http\Requests\Car\PhotoUploadRequest;
use App\Models\Car\CarPhoto;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PhotoUploadController extends __BaseController {
	public function __invoke(PhotoUploadRequest $request) {
		$file = $request->allFiles()["file"];
		[$id_for_link_form_and_uploaded_photos, $filename] = explode("_-_-_", $file->getClientOriginalName());
		$path = "temp_photos/" . $id_for_link_form_and_uploaded_photos;
		$pathAndFilename = $path . "/" . $filename;

		Storage::disk("local")->delete($pathAndFilename); // на всякий случай
		$file->storeAs($path, $filename, "local");
		if (Storage::disk("local")->missing($pathAndFilename)) throw new PhotoUploadException($filename);

		if ($newFile = CarPhoto::correctPhotoIfNnecessary(Storage::disk("local")->path("") . $pathAndFilename)) {
			Storage::disk("local")->delete($pathAndFilename);
			$newFile = Str::remove(Storage::disk("local")->path(""), $newFile);
			Storage::disk("local")->move($newFile, $pathAndFilename);
		}

		return "/photo-upload $filename DONE";
	}
}
