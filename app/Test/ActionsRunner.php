<?php

namespace App\Test;

use App\Test\Action_1;
use App\Test\Action_2;
use App\Test\Action_3;
use App\Test\Action_4;

class ActionsRunner {
	public function __invoke() {
		$actions = [Action_1::class, Action_2::class, Action_3::class, Action_4::class];
		foreach ($actions as $action) app($action)();
	}
}