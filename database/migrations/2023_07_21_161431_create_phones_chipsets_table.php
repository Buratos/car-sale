<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
	public function up(): void {
		Schema::create('phones_chipsets', function (Blueprint $table) {
			$table->id();
			$table->string("name", 50);
		});
	}

	public function down(): void {
		Schema::dropIfExists('phones_chipsets');
	}
};
