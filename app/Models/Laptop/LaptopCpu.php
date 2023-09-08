<?php

namespace App\Models\Laptop;

use Illuminate\Database\Eloquent\Model;

class LaptopCpu extends Model {
	protected $table = 'laptops_cpus';
	public $timestamps = false;

	public function laptops() {
		return $this->hasMany(Laptop::class, "cpu_id");
	}
}
