<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
	public function up(): void {
		Schema::create('laptops_cpus', function (Blueprint $table) {
			$table->id();
			$table->string("name", 70);
		});
	}

	public function down(): void {
		Schema::dropIfExists('laptops_cpus');
	}
};
