// некоторые фотографии на диске - это мусор. Его надо удалить
function cleanPhotosOfGarbage() {
	$allFiles = Storage::disk('public')->files("cars_photos/");
	global $files;
	foreach ($allFiles as $file) $files[pathinfo($file, PATHINFO_BASENAME)] = 1;
	unset($allFiles);

	CarPhoto::chunk(50000, function (Collection $photos) {
		global $files;

		foreach ($photos as $photo)
			if (isset($files[$photo->filename])) unset($files[$photo->filename]);
			else $photo->delete();
	});
	foreach ($files as $file => $value) Storage::disk("public")->delete("cars_photos/" . $file);
}

// удаление папок в Storage->temp_photos, которые старее чем $hours
function cleanDiskOf_temp_photos_Garbage($hours) {
	$directories = Storage::disk("public")->directories("/temp_photos/");
	foreach ($directories as $dir) {
		$date = Storage::disk("public")->lastModified($dir);
		if (!$date) $timeDifference = $hours + 1;
		else $timeDifference = \Carbon\Carbon::now()->diffInHours(Carbon::createFromTimestamp($date));
		if ($timeDifference > $hours) Storage::disk("public")->deleteDirectory($dir);
	}
}
