<?php

namespace App\Models\Laptop;

use Illuminate\Database\Eloquent\Model;

class LaptopDisplayResolution extends Model {
	protected $table = 'laptops_display_resolutions';
	public $timestamps = false;

	public function laptops() {
		return $this->hasMany(Laptop::class, "display_resolution_id");
	}
}
