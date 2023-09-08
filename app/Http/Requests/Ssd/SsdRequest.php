<?php

namespace App\Http\Requests\Ssd;

use Illuminate\Foundation\Http\FormRequest;

class SsdRequest extends FormRequest {
	public function rules(): array {
		return [

		];
	}

	public function authorize(): bool {
		return true;
	}
}
