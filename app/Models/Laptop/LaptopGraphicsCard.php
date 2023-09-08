<?php

namespace App\Models\Laptop;

use Illuminate\Database\Eloquent\Model;

class LaptopGraphicsCard extends Model {
	protected $table = 'laptops_graphics_cards';
	public $timestamps = false;

	public function laptops() {
		return $this->hasMany(Laptop::class, "graphics_card_id");
	}

}
