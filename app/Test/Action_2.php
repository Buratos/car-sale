<?php

namespace App\Test;

use Illuminate\Support\Facades\Log;

class Action_2 {
	public function __invoke() {
		Log::alert("ВЫПОЛНЕН class Action_ 22");
	}
}