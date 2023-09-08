<?php

namespace App\Test;

use Illuminate\Support\Facades\Log;

class Action_1 {
	public function __invoke() {
		Log::alert("ВЫПОЛНЕН class Action_1");
	}
}