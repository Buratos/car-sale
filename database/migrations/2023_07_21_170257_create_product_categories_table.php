<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
	public function up(): void {
		Schema::create('product_categories', function (Blueprint $table) {
			$table->id();
			$table->string("table_name", 50);
			$table->string("title", 50);
			$table->unsignedTinyInteger("level")->default(1);
			$table->unsignedSmallInteger("belongs_to")->default(1);
		});
	}

	public function down(): void {
		Schema::dropIfExists('product_categories');
	}
};

