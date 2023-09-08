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
		Schema::create('user_phones', function (Blueprint $table) {
			$table->id();
			$table->string("number", 20);
			//создание поля для связывания с таблицей user
			$table->foreignId('user_id')->default(0);            //создание внешнего ключа для поля 'user_id', который связан с полем id таблицы 'users'
//            $table->foreign('user_id')->references('id')->on('users');
//			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('user_phones');
	}
};
