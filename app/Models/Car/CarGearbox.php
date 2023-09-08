<?php

namespace App\Models\Car;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarGearbox extends Model {
	protected $table = 'cars_gearboxes';
	public $timestamps = false;
	use HasFactory;

	public function cars() {
		return $this->hasMany(Car::class,"gearbox_id");
	}
}
