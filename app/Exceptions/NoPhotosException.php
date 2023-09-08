<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class NoPhotosException extends Exception {
	/**
	 * Render the exception as an HTTP response.
	 */
	public function render(Request $request) {

		return new JsonResponse([
			"message" => __("There are no photos. Upload photos please")
			//			"message" => $this->getMessage()
		], 550);
	}
}
