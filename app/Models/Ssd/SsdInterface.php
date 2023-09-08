<?php

namespace App\Models\Ssd;

use Illuminate\Database\Eloquent\Model;

class SsdInterface extends Model {
	protected $table = 'ssds_interfaces';
	public $timestamps = false;

	public function ssds() {
		return $this->hasMany(Ssd::class,"interface_id");
	}

}
