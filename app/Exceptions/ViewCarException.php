<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Request;

class ViewCarException extends Exception {
	/**
	 * Render the exception as an HTTP response.
	 */
	public function render(Request $request) {
		return response()->redirectToRoute("cars.index");
	}
}
