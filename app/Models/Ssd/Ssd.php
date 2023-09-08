<?php

namespace App\Models\Ssd;

use App\Models\__ProductModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;

class Ssd extends __ProductModel {
	use HasFactory;

	static $pluralWords = ["ssd", "ssds", "ssds"];

	public function ssdBrand() {
		return $this->belongsTo(SsdBrand::class, "brand_id");
	}

	public function getBrandAttribute() {
		return $this->ssdBrand->name;
	}

	public function ssdModel() {
		return $this->belongsTo(SsdModel::class, "model_id");
	}

	public function getModelAttribute() {
		return $this->ssdModel->name;
	}

	public function getFullNameAttribute() {
		return $this->ssdBrand->name . " " . $this->ssdModel->name;
	}

	public function ssdInterface() {
		return $this->belongsTo(SsdInterface::class, "interface_id");
	}

	public function getInterfaceAttribute() {
		return $this->ssdInterface->name;
	}

	public function getPhotoUrl() {
		return Arr::random(Storage::disk('root/public')->files("img/categories/ssds/"));
	}

}
