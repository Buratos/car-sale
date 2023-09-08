<?php

namespace App\Models\Laptop;

use App\Models\__ProductModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;

class Laptop extends __ProductModel {
	use HasFactory;

	static $pluralWords = ["ноутбук", "ноутбука", "ноутбуков"];

	public function laptopBrand() {
		return $this->belongsTo(LaptopBrand::class, "brand_id");
	}

	public function getBrandAttribute() {
		return $this->laptopBrand->name;
	}

	public function laptopModel() {
		return $this->belongsTo(LaptopModel::class, "model_id");
	}

	public function getModelAttribute() {
		return $this->laptopModel->name;
	}

	public function getFullNameAttribute() {
		return $this->laptopBrand->name . " " . $this->laptopModel->name;
	}

	public function laptopCpu() {
		return $this->belongsTo(LaptopCpu::class, "cpu_id");
	}

	public function getCpuAttribute() {
		return $this->laptopCpu->name;
	}

	public function laptopDisplayResolution() {
		return $this->belongsTo(LaptopDisplayResolution::class, "display_resolution_id");
	}

	public function getDisplayResolutionAttribute() {
		return $this->laptopDisplayResolution->name;
	}

	public function laptopGraphicsCard() {
		return $this->belongsTo(LaptopGraphicsCard::class, "graphics_card_id");
	}

	public function getGraphicsCardAttribute() {
		return $this->laptopGraphicsCard->name;
	}

	public function getPhotoUrl() {
		return Arr::random(Storage::disk('root/public')->files("img/categories/laptops/"));
	}
}
