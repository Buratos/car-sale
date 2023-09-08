<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('cars', function (Blueprint $table) {
			$table->id();
			$table->foreignId("brand_id")->index();
			$table->foreignId("model_id")->index();
			$table->foreignId("body_type_id")->index();
			$table->foreignId("color_id");
			$table->foreignId("gearbox_id");
			$table->foreignId("engine_type_id");
			$table->smallInteger("engine_capacity")->default(1500);
			$table->smallInteger("engine_power")->default(100);
			$table->float("fuel_consumption")->default(8);
			$table->smallInteger("production_year")->default(2010)->index();
			$table->smallInteger("clearance")->default(160);
			$table->smallInteger("wheelbase")->default(270);
			$table->tinyInteger("number_doors")->default(4);
			$table->tinyInteger("number_places")->default(5);
			$table->smallInteger("length")->default(4400);
			$table->smallInteger("width")->default(1760);
			$table->smallInteger("height")->default(1750);
			$table->mediumInteger("mileage")->default(0);
			$table->boolean("was_in_accident")->default(false);
			$table->mediumInteger("price")->default(0);
			$table->foreignId("user_id")->default(1);
			$table->timestamps();
			$table->softDeletes();
//			$table->engine = "MEMORY";
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('cars');
	}
};

/*

*/
