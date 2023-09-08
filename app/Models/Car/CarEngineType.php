<?php

namespace App\Models\Car;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarEngineType extends Model {
	protected $table = 'cars_engine_types';
	public $timestamps = false;
	use HasFactory;

	public function cars() {
		return $this->hasMany(Car::class,"engine_type_id");
	}
}
