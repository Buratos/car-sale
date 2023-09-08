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
		Schema::create('cars_photos', function (Blueprint $table) {
			$table->id();
			$table->string("filename", 50);
			$table->foreignId("car_id");
			$table->tinyInteger("number")->default(1);
			$table->string("description",200);
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('cars_photos');
	}
};
