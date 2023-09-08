<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
	public function up(): void {
		Schema::create('ssds', function (Blueprint $table) {
			$table->id();
			$table->foreignId("brand_id")->index();
			$table->foreignId("model_id");
			$table->unsignedTinyInteger("type")->default(1);
			$table->unsignedMediumInteger("capacity")->default(256)->index();
			$table->foreignId("interface_id")->index();
			$table->unsignedMediumInteger("speed_read")->default(3300);
			$table->unsignedMediumInteger("speed_write")->default(3000);
			$table->unsignedSmallInteger("price")->default(0);
			$table->timestamps();
			$table->softDeletes();
		});
	}

	public function down(): void {
		Schema::dropIfExists('ssds');
	}
};

