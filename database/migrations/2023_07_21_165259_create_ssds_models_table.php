<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
	public function up(): void {
		Schema::create('ssds_models', function (Blueprint $table) {
			$table->id();
			$table->foreignId("brand_id")->constrained('ssds_brands');
			$table->string("name", 50);
		});
	}

	public function down(): void {
		Schema::dropIfExists('ssds_models');
	}
};
