<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ErrorController extends Controller {
   public function noPermission() {
      $response = ["errorMessage" => __("You do not have permission to access this page")];
      return view("errors.sections_error", $response);
   }
   public function cantCreateNewAd() {
      $response = ["errorMessage" => __("Something went wrong. We don't know what yet. Failed to create your ad. You can try again")];
      return view("errors.sections_error", $response);
   }
}
