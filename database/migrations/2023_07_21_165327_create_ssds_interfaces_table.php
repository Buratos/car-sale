<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
	public function up(): void {
		Schema::create('ssds_interfaces', function (Blueprint $table) {
			$table->id();
			$table->string("name", 30);

		});
	}

	public function down(): void {
		Schema::dropIfExists('ssds_interfaces');
	}
};
