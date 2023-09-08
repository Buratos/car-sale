<?php

namespace App\Models\Ssd;

use Illuminate\Database\Eloquent\Model;

class SsdBrand extends Model {
	protected $table = 'ssds_brands';
	public $timestamps = false;

	public function ssds() {
		return $this->hasMany(Ssd::class,"brand_id");
	}

	public function models() {
		return $this->hasMany(SsdModel::class,"brand_id");
	}
}
