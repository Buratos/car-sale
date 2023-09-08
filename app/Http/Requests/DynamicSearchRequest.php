<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DynamicSearchRequest extends FormRequest {
	public function rules(): array {
		return ["search_str" => ["required", "string", "min:3"]];
	}

	public function authorize(): bool {
		return true;
	}
}
