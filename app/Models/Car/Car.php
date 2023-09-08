<?php

namespace App\Models\Car;

use App\Listeners\DeleteCarPhotos;
use App\Models\__ProductModel;
use App\Models\Traits\Filterable;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class Car extends __ProductModel {
	use HasFactory, SoftDeletes;
	protected $guarded = [];

	static $pluralWords = ["машина", "машины", "машин"];

	public function user() {
		return $this->belongsTo(User::class);
	}

	public function brandName() {
		return $this->belongsTo(CarBrand::class, "brand_id");
	}

	public function getBrandAttribute() {
		return $this->brandName->name;
	}

	public function modelName() {
		return $this->belongsTo(CarModel::class, "model_id");
	}

	public function getModelAttribute() {
		return $this->modelName->name;
	}

	public function getFullNameAttribute() {
		return $this->brandName->name . " " . $this->modelName->name;
	}

	public function color() {
		return $this->belongsTo(CarColor::class, "color_id");
	}

	public function bodyType() {
		return $this->belongsTo(CarBodyType::class, "body_type_id");
	}

	public function engineType() {
		return $this->belongsTo(CarEngineType::class, "engine_type_id");
	}

	public function gearbox() {
		return $this->belongsTo(CarGearbox::class, "gearbox_id");
	}

	public function photos() {
		return $this->hasMany(CarPhoto::class,)->orderBy("number");
	}

	public function descriptionBody() {
		return $this->hasOne(CarDescription::class);
	}

	public function getDescriptionAttribute() {
		return $this->descriptionBody->text;
	}

// ▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪
	protected static function booted() {
//		Log::channel('for_debug')->debug("Car::booted()");

		static::created(function ($model) {
			Log::channel('for_debug')->debug("__ProductModel::booted()");
			set_flag_tableUpdated_in_cache($model);

			if (method_exists(get_called_class(), 'childCreated'))
				forward_static_call([get_called_class(), 'childCreated']);
		});

		static::updated(function ($model) {
			set_flag_tableUpdated_in_cache($model);
		});

		static::deleting(function ($car) {
			// закомментировал удаление фоток с диска
			foreach ($car->photos as $photo) {
				Storage::disk("public")->delete("/cars_photos/" . $photo->filename);
				Storage::disk("public")->delete("/cars_photos/small_duplicates/" . $photo->filename);
			}
			$car->photos()->delete();
		});

		static::deleted(function ($model) {
			set_flag_tableUpdated_in_cache($model);
		});

		static::restored(function ($model) {
			set_flag_tableUpdated_in_cache($model);
		});
	}

	// ▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪
}

