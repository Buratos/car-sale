<?php

namespace App\Http\Controllers\Laptop;

use App\Http\Controllers\Controller;
use App\Services\LaptopService;

class __BaseController extends Controller {
   public $service;

   public function __construct(LaptopService $service) {
      $this->service = $service;
   }

}
