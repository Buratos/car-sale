<?php

namespace App\Mail;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PlainTextLetter extends Mailable {
   use Queueable, SerializesModels;

   /**
    * Create a new message instance.
    *
    * @return void
    */
   public function __construct() {
      //
   }

   /**
    * Build the message.
    *
    * @return $this
    */
   public function build() {
      $date = Carbon::now();
      $date = $date->hour . ":" . $date->minute . ":" . $date->second . "  " . $date->day . "/" . $date->month . "/" . $date->year;
      return $this->from("zolotoedermo@gmail.com", $date . "  Plain text letter test")->view('emails.plain_text_letter');
   }
}
