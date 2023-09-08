<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InputParametersRequest extends FormRequest {
   /**
    * Determine if the user is authorized to make this request.
    *
    * @return bool
    */
   public function authorize() {
      return true;
   }

   /**
    * Get the validation rules that apply to the request.
    *
    * @return array
    */
   public function rules() {
      return [
         //
      ];
   }

   public function all($keys = null): array {
      $input_data = parent::all($keys);
      $output_data = [];
      foreach ($input_data as $key => $elem) {
         if ($key == "description") {
            $output_data[$key] = $elem;
         } else if (strpos($elem, "~") > 0) {
            $output_data[$key] = explode("~", $elem);
         } else $output_data[$key] = $elem;
      }
      return $output_data;
   }
}
