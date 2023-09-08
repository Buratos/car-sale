<?php

namespace App\Models\Car;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarColor extends Model {
	protected $table = 'cars_colors';
	public $timestamps = false;
	use HasFactory;

	public function cars() {
		return $this->hasMany(Car::class,"color_id");
	}
}
