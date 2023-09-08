<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
	/**
	 * Run the migrations.
	 */
	public function up(): void {
		Schema::create('tests', function (Blueprint $table) {
			$table->id();
			$table->string('brand', 30);
			$table->string('brand_index', 30)->index();
			$table->string('model', 30);
			$table->string('model_index', 30)->index();
			$table->smallInteger("power");
			$table->smallInteger("power_index")->index();
			$table->smallInteger("clearance")->default(160);
			$table->smallInteger("wheelbase")->default(270);
			$table->smallInteger("length")->default(4400);
			$table->smallInteger("width")->default(1760);
			$table->smallInteger("height")->default(1750);
			$table->mediumInteger("mileage")->default(0);
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void {
		Schema::dropIfExists('tests');
	}
};
