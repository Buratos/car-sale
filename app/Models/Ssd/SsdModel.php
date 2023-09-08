<?php

namespace App\Models\Ssd;

use Illuminate\Database\Eloquent\Model;

class SsdModel extends Model {
	protected $table = 'ssds_models';
	public $timestamps = false;

	public function ssds() {
		return $this->hasMany(Ssd::class,"model_id");
	}

	public function ssdBrand() {
		return $this->belongsTo(SsdBrand::class,"brand_id");
	}

	public function getBrandAttribute() {
		return $this->ssdBrand->name;
	}

}
