<?php

namespace App\Models\test;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemoryTableRow extends Model {
	use HasFactory;
	public $timestamps = false;
	protected $fillable = ['name', 'price', 'category', 'weight',];

}

