<?php

namespace App\Jobs;

use App\Models\Testtest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class TestJob implements ShouldQueue {
   use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

   public $param;

   /**
    * Create a new job instance.
    *
    * @return void
    */
   public function __construct($param) {
      $this->param = $param;
   }

   /**
    * Execute the job.
    *
    * @return void
    */
   public function handle() {
      $myfile = fopen("testfile . txt", "a");
      $txt = $this->param . " " . now() . "\n";
      fwrite($myfile, $txt);
      $txt = "---------------------------------------\n";
      fwrite($myfile, $txt);
      fclose($myfile);
      for ($i = 0, $a = 0; $i < 10; $i++) {
         $a++;
      }
      Testtest::create(["name" => $this->param . " " . now()]);
      Log::channel('daily')->notice("Тестовое сообщение из задания в очереди  " . now());
      Log::build([
        'driver' => 'single',
        'path' => storage_path('logs/custom.log'),
      ])->info(' Log::build( из очереди');

      /*            ech("ВЫПОЛНЕНИЕ ОЧЕРЕДИ - " . $this->param);
                  var_dump("ВЫПОЛНЕНИЕ ОЧЕРЕДИ - " . $this->param);*/

   }
}
