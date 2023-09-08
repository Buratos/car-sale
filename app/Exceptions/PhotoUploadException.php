<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PhotoUploadException extends Exception {
	/**
	 * Render the exception as an HTTP response.
	 */
	public function render(Request $request) {
		/*		return response()->json([
					'error_message' => $this->getMessage(),
					'test_test'     => "дополнительное поле test"
				]);*/
		return new JsonResponse([
			"filename" => $this->getMessage(),
			"message"  => __("There was an unknown problem uploading photo to the server. Please upload your photos again")
		], 551);
	}
}
