<?php

namespace App\Http\Controllers\Car;

use App\Http\Controllers\Controller;
use App\Services\CarService;

class __BaseController extends Controller {
   public $service;

   public function __construct(CarService $service) {
      $this->service = $service;
   }

}
