<?php

namespace App\Models\Phone;

use Illuminate\Database\Eloquent\Model;

class PhoneChipset extends Model {
	protected $table = 'phones_chipsets';
	public $timestamps = false;

	public function phones() {
		return $this->hasMany(Phone::class,"chipset_id");
	}
}
