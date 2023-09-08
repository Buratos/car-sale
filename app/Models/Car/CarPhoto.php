<?php

namespace App\Models\Car;

use App\Models\__ProductPhoto;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Intervention\Image\Facades\Image;

class CarPhoto extends __ProductPhoto {
	protected $table = 'cars_photos';
//   public $timestamps = false;
	use HasFactory;

	protected $guarded = [];

	public function car() {
		return $this->belongsTo(Car::class);
	}

	static public function transformPhoto($filename) {
		$image = Image::make($filename)->resize(300, null, function ($constraint) { $constraint->aspectRatio(); })->save("storage/temp_photos/XXRFHXZJIZUBJJKDNFYEJGOENVFGD.webp", 90, 'webp');
	}

}
