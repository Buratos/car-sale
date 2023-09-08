<?php

namespace App\Models\Laptop;

use Illuminate\Database\Eloquent\Model;

class LaptopModel extends Model {
	protected $table = 'laptops_models';
	public $timestamps = false;

	public function laptops() {
		return $this->hasMany(Laptop::class,"model_id");
	}

	public function laptopBrand() {
		return $this->belongsTo(LaptopBrand::class,"brand_id");
	}

	public function getBrandAttribute() {
		return $this->laptopBrand->name;
	}

}
