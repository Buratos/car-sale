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
		Schema::create('cars_colors', function (Blueprint $table) {
			$table->id();
			$table->string("name", 40);
/*			$table->string("name", 30);
			$table->string("value", 9)->default("");*/
		});
		/*        $colors = [["белый", "#FFFFFF"],
								["светло серый", "#D0D0D0"],
								["тёмно серый", "#858585"],
								["черный", "#000000"],
								["синий", "#6694FF"],
								["зеленый", "#139915"],
								["розовый", "#FFC4C8"],
								["красный", "#E92045"],
								["оранжевый", "#FDB165"],
								["голубой", "#69F6FD"],
								["салатовый", "#9CFDD1"],
								["коричневый", "#4A2E11"],
								["жёлтый", "#FFDD00"],
								["фиолетовый", "#FF56FC"]];

						foreach ($colors as $color) DB::table("colors")->insert(["title" => $color[0], "value" => $color[1]]);*/
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('cars_colors');
	}
};
