<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;

abstract class __ProductModel extends Model {
	static public $tableMemory;

	static function getPluralWords() {
		$className = get_called_class();
		foreach ($className::$pluralWords as $word) {
			$pluralWords[] = __($word);
		}
		return $pluralWords;
	}

	// creates a duplicate table with ENGINE = MEMORY and named [table_name]__memory.
	// It is necessary for count filter numbers
	static public function createDuplicateTableInMemory() {
		$className = get_called_class();
		$tableName = (new $className)->getTable();
		$new_table_name = $tableName . "__memory";
		self::$tableMemory = $new_table_name;
		Schema::dropIfExists($new_table_name);

		// клонирую структуру таблицы
		DB::select("CREATE TABLE $new_table_name LIKE $tableName;");
		// изменяем ENGINE таблицы "cars__memory" на MEMORY
		DB::statement("ALTER TABLE $new_table_name ENGINE = MEMORY;");
		// клонирую данные между таблицами
		DB::select("INSERT INTO $new_table_name SELECT * FROM $tableName;");
		if (config('app.debug')) Log::channel('for_debug')->info("TABLE $new_table_name CREATED and FILLED");
	}
}
