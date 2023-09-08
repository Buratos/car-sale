<?php

namespace App\Providers;

use App\Models\Car\Car;
use App\Policies\PermissionPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider {
   /**
    * The policy mappings for the application.
    *
    * @var array<class-string, class-string>
    */
   protected $policies = [
      // 'App\Models\Model' => 'App\Policies\ModelPolicy',
//      Car::class => CarPolicy::class
   ];

   /**
    * Register any authentication / authorization services.
    *
    * @return void
    */
   public function boot() {
      $this->registerPolicies();

      Gate::define('create', function (User $user, Car $car) {
         return !is_null($user);
      });
   }
}
