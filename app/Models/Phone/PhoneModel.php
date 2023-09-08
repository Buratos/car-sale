<?php

namespace App\Models\Phone;

use Illuminate\Database\Eloquent\Model;

class PhoneModel extends Model {
	protected $table = 'phones_models';
	public $timestamps = false;

	public function phones() {
		return $this->hasMany(Phone::class,"model_id");
	}

	public function phoneBrand() {
		return $this->belongsTo(PhoneBrand::class,"brand_id");
	}

	public function getBrandAttribute() {
		return $this->phoneBrand->name;
	}

}
