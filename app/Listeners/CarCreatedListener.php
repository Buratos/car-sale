<?php

namespace App\Listeners;

use App\Events\CarCreatedEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CarCreatedListener {
   /**
    * Create the event listener.
    *
    * @return void
    */
   public function __construct() {
      //
   }

   /**
    * Handle the event.
    *
    * @param \App\Events\CarCreatedEvent $event
    * @return void
    */
   public function handle(CarCreatedEvent $event) {
      $car_title = $event->car->name . $event->car->production_year;
      return false;
   }
}
