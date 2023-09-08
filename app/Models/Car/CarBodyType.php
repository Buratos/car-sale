<?php

namespace App\Models\Car;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarBodyType extends Model {
	protected $table = 'cars_body_types';
	use HasFactory;

	public $timestamps = false;

	public function cars() {
		return $this->hasMany(Car::class,"body_type_id");
	}

}
