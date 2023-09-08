<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
	public function up(): void {
		Schema::create('laptops_graphics_cards', function (Blueprint $table) {
			$table->id();
			$table->string("name", 50);
		});
	}

	public function down(): void {
		Schema::dropIfExists('laptops_graphics_cards');
	}
};
