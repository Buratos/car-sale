<?php

namespace App\Policies;

use App\Models\Car\Car;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CarPolicy {
   use HandlesAuthorization;

   /**
    * Determine whether the user can view any models.
    *
    * @param \App\Models\User $user
    * @return \Illuminate\Auth\Access\Response|bool
    */
   public function edit(User $user, Car $car) {
      return $user->isAdmin() || $car->user()->id == $user->id;
   }
   /**
    * Determine whether the user can view any models.
    *
    * @param \App\Models\User $user
    * @return \Illuminate\Auth\Access\Response|bool
    */
   public function viewAny(User $user) {
      //
   }

   /**
    * Determine whether the user can view the model.
    *
    * @param \App\Models\User $user
    * @param \App\Models\Car\Car $car
    * @return \Illuminate\Auth\Access\Response|bool
    */
   public function view(User $user, Car $car) {
      //
   }

   /**
    * Determine whether the user can create models.
    *
    * @param \App\Models\User $user
    * @return \Illuminate\Auth\Access\Response|bool
    */
   public function create(?User $user) {
//      dd("create  CarPolicy");
      return true;
//      return !empty($user) ? Response::allow() : Response::deny('You do not have permission to edit this ad.');
   }

   /**
    * Determine whether the user can update the model.
    *
    * @param \App\Models\User $user
    * @param \App\Models\Car\Car $car
    * @return \Illuminate\Auth\Access\Response|bool
    */
   public function update(User $user, Car $car) {
      return ($user->isAdmin() || $car->user()->id == $user->id ) ? Response::allow()
        : Response::deny('You do not have permission to edit this ad.');;
//      return $user->isAdmin() || $car->user()->id == $user->id;
   }

   /**
    * Determine whether the user can delete the model.
    *
    * @param \App\Models\User $user
    * @param \App\Models\Car\Car $car
    * @return \Illuminate\Auth\Access\Response|bool
    */
   public function delete(User $user, Car $car) {
      //
   }

   /**
    * Determine whether the user can restore the model.
    *
    * @param \App\Models\User $user
    * @param \App\Models\Car\Car $car
    * @return \Illuminate\Auth\Access\Response|bool
    */
   public function restore(User $user, Car $car) {
      //
   }

   /**
    * Determine whether the user can permanently delete the model.
    *
    * @param \App\Models\User $user
    * @param \App\Models\Car\Car $car
    * @return \Illuminate\Auth\Access\Response|bool
    */
   public function forceDelete(User $user, Car $car) {
      //
   }
}
