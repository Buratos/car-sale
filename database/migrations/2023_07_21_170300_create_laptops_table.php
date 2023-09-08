<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
	public function up(): void {
		Schema::create('laptops', function (Blueprint $table) {
			$table->id();
			$table->foreignId( "brand_id")->index();
			$table->foreignId( "model_id");
			$table->foreignId("cpu_id")->index();
			$table->foreignId("graphics_card_id");
			$table->unsignedTinyInteger("ram")->default(8)->index();
			$table->unsignedSmallInteger("ssd")->default(512);
			$table->unsignedFloat("display_size")->default(15.6);
			$table->foreignId( "display_resolution_id");
			$table->unsignedTinyInteger("battery_power")->default(70);
			$table->unsignedSmallInteger("weight")->default(2300);
			$table->unsignedSmallInteger("price")->default(0);
			$table->timestamps();
			$table->softDeletes();
		});
	}

	public function down(): void {
		Schema::dropIfExists('laptops');
	}
};
