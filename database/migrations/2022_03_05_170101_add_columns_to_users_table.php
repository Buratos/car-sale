<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::table('users', function (Blueprint $table) {
			$table->string("surname", 40)->nullable();
			$table->char("sex", 1)->nullable();
			$table->date("bithdate")->nullable();
			$table->text("address", 300)->nullable();
			$table->tinyInteger("role")->default(1); // 0 = admin
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::table('users', function (Blueprint $table) {
			$table->dropColumn(["surname", "sex", "bithdate", "address", "role"]);
		});
	}
};
