<?php

namespace App\Models\Car;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarModel extends Model {
	protected $table = 'cars_models';
	public $timestamps = false;
	use HasFactory;

	protected $guarded = [];

	public function cars() {
		return $this->hasMany(Car::class,"model_id");
	}

	public function brandName() {
		return $this->belongsTo(CarBrand::class,"brand_id");
	}
}
