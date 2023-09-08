<?php

namespace App\Http\Requests\Car;

use Illuminate\Foundation\Http\FormRequest;

class PhotoUploadRequest extends FormRequest {
	public function rules(): array {
		return [
			"file" => ["required", "file", "image", "max:15240", "dimensions:min_width=600,max_width=10000,min_height=300,max_height=10000"],
		];
	}

	public function authorize(): bool {
		return true;
	}
}
