<?php

namespace App\Http\Controllers\Phone;

use App\Http\Controllers\Controller;
use App\Services\PhoneService;

class __BaseController extends Controller {
   public $service;

   public function __construct(PhoneService $service) {
      $this->service = $service;
   }

}
