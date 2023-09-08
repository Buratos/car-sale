<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
	public function up(): void {
		Schema::create('laptops_display_resolutions', function (Blueprint $table) {
			$table->id();
			$table->string("name", 35);
		});
	}

	public function down(): void {
		Schema::dropIfExists('laptops_display_resolutions');
	}
};
