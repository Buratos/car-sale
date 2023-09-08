<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
	public function up(): void {
		Schema::create('cars_descriptions', function (Blueprint $table) {
			$table->id();
			$table->string('text',4000);
			$table->foreignId('car_id');          //создание внешнего ключа для поля 'user_id', который связан с полем id таблицы 'users'
			$table->softDeletes();
		});
	}

	public function down(): void {
		Schema::dropIfExists('cars_descriptions');
	}
};
