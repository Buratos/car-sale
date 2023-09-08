<?php

namespace App\Http\Requests\Phone;

use Illuminate\Foundation\Http\FormRequest;

class PhoneRequest extends FormRequest {
	public function rules(): array {
		return [

		];
	}

	public function authorize(): bool {
		return true;
	}
}
