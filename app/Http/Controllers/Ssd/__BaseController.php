<?php

namespace App\Http\Controllers\Ssd;

use App\Http\Controllers\Controller;
use App\Services\Ssd\SsdService;

class __BaseController extends Controller {
   public $service;

   public function __construct(SsdService $service) {
      $this->service = $service;
   }

}
