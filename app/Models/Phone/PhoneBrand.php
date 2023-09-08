<?php

namespace App\Models\Phone;

use Illuminate\Database\Eloquent\Model;

class PhoneBrand extends Model {
	protected $table = 'phones_brands';
	public $timestamps = false;

	public function phones() {
		return $this->hasMany(Phone::class,"brand_id");
	}

	public function models() {
		return $this->hasMany(PhoneModel::class,"brand_id");
	}
}
