<?php

namespace App\Models\Car;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarBrand extends Model {
	protected $table = 'cars_brands';
	use HasFactory;

	public $timestamps = false;

	public function cars() {
		return $this->hasMany(Car::class);
	}

	public function modelNames() {
		return $this->hasMany(CarModel::class,"brand_id");
	}

	public function getModelsAttribute() {
		return $this->modelNames->pluck("name")->toArray();
	}

}

// model_id  brand_id brandName modelName