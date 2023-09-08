<?php

namespace App\Models\Laptop;

use Illuminate\Database\Eloquent\Model;

class LaptopBrand extends Model {
	protected $table = 'laptops_brands';
	public $timestamps = false;

	public function laptops() {
		return $this->hasMany(Laptop::class,"brand_id");
	}

	public function models() {
		return $this->hasMany(LaptopModel::class,"brand_id");
	}
}
