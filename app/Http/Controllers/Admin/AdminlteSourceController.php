<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Ssd\BaseController;
use Illuminate\Http\Request;

class AdminlteSourceController extends BaseController {
   /**
    * Handle the incoming request.
    *
    * @param \Illuminate\Http\Request $request
    * @return \Illuminate\Http\Response
    */
   public function __invoke(Request $request) {
      return view("admin.adminLTE320_source");
   }
}
