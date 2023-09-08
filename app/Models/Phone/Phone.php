<?php

namespace App\Models\Phone;

use App\Models\__ProductModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;

class Phone extends __ProductModel {
	use HasFactory;

	static $pluralWords = ["телефон", "телефона", "телефонов"];

	public function phoneBrand() {
		return $this->belongsTo(PhoneBrand::class, "brand_id");
	}

	public function getBrandAttribute() {
		return $this->phoneBrand->name;
	}

	public function phoneModel() {
		return $this->belongsTo(PhoneModel::class, "model_id");
	}

	public function getModelAttribute() {
		return $this->phoneModel->name;
	}

	public function getFullNameAttribute() {
		return $this->phoneBrand->name . " " . $this->phoneModel->name;
	}

	public function phoneChipset() {
		return $this->belongsTo(PhoneChipset::class, "chipset_id");
	}

	public function getChipsetAttribute() {
		return $this->phoneChipset->name;
	}

	public function getPhotoUrl() {
		return Arr::random(Storage::disk('root/public')->files("img/categories/phones/"));
	}

}
