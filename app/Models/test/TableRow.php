<?php

namespace App\Models\test;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TableRow extends Model {
	use HasFactory;

	public $timestamps = false;
	protected $fillable = ['name', 'price', 'category', 'weight',];

}

