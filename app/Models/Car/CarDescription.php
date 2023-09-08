<?php

namespace App\Models\Car;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CarDescription extends Model {
	protected $table = 'cars_descriptions';
	public $timestamps = false;
	use SoftDeletes, HasFactory;

	protected $fillable = [
		'text',
	];

	public function car() {
		return $this->belongsTo(Car::class);
	}

}
