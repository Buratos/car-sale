<?php

namespace App\Http\Requests\Car;

use Illuminate\Foundation\Http\FormRequest;

class ExtendedProductCardRequest extends FormRequest {
	public function rules(): array {
		return ["id" => ["required", "integer", "min:1"]];
	}

	public function authorize(): bool {
		return true;
	}
}
