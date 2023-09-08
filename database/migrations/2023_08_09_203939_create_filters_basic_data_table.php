<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
	public function up(): void {
		Schema::create('filters__basic_data', function (Blueprint $table) {
			$table->id();
			$table->string("table", 30);
			$table->string("column", 40);
			$table->char("type", 2);
			$table->string("title_on_site", 70)->default("");
			$table->string("binded_table_name", 40)->default("");
			$table->string("binded_table_column", 40)->default("");
			$table->string("belongs_to", 40)->default("");
			$table->text("titles_min_max");
		});
	}

	public function down(): void {
		Schema::dropIfExists('filters__basic_data');
	}
};
