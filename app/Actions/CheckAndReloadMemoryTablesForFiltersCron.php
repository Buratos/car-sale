<?php

namespace App\Actions;

use App\Models\Car\Car;
use App\Models\Laptop\Laptop;
use App\Models\Phone\Phone;
use App\Models\Ssd\Ssd;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;

class CheckAndReloadMemoryTablesForFiltersCron {
	public $modelClasses = [Car::class, Laptop::class, Phone::class, Ssd::class];

	public function __invoke() {
		foreach ($this->modelClasses as $modelClass) {
			$tableFrom = (new $modelClass)->getTable();
			$tableTo = $tableFrom . "__memory";
			if (!Schema::hasTable($tableTo) || !DB::table($tableTo)->count() || Cache::tags("FILTERS $tableFrom")->has("TABLE $tableFrom UPDATED")) {
//				Log::channel('for_debug')->debug("создаю таблицу  " . $tableTo);
				$modelClass::createDuplicateTableInMemory();
				Cache::tags("FILTERS $tableFrom")->forget("TABLE $tableFrom UPDATED");
			}
		}
	}
}
