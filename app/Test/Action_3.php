<?php

namespace App\Test;

use Illuminate\Support\Facades\Log;

class Action_3 {
	public function __invoke() {
		Log::alert("ВЫПОЛНЕН class Action_ 333");
	}
}