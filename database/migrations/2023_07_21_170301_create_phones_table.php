<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
	public function up(): void {
		Schema::create('phones', function (Blueprint $table) {
			$table->id();
			$table->foreignId("brand_id")->index();
			$table->foreignId("model_id")->index();
			$table->foreignId("chipset_id");
			$table->unsignedTinyInteger("ram")->default(4)->index();
			$table->unsignedSmallInteger("storage")->default(64);
			$table->unsignedFloat("display_size")->default(6.3);
			$table->unsignedSmallInteger("camera")->default(48);
			$table->unsignedMediumInteger("battery_capacity")->default(4000);
			$table->unsignedSmallInteger("weight")->default(200);
			$table->unsignedMediumInteger("price")->default(0);
			$table->timestamps();
			$table->softDeletes();
		});
	}

	public function down(): void {
		Schema::dropIfExists('phones');
	}
};
