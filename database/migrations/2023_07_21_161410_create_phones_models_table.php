<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
	public function up(): void {
		Schema::create('phones_models', function (Blueprint $table) {
			$table->id();
			$table->foreignId("brand_id")->constrained('phones_brands');
			$table->string("name", 70);
		});
	}

	public function down(): void {
		Schema::dropIfExists('phones_models');
	}
};
