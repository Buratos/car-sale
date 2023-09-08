<?php

namespace App\Http\Middleware;

use App\Models\Car\Car;
use Closure;
use Illuminate\Http\Request;

class UpdateCarMiddleware {
   /**
    * Handle an incoming request.
    *
    * @param \Illuminate\Http\Request $request
    * @param \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
    * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
    */
   public function handle(Request $request, Closure $next) {
      $user = auth()->user();
      $can = $user ? ($user->isAdmin() || $user->id == Car::whereId($request->id)->first()->user_id) : false;
      if ($can) return $next($request);
      else abort(403);
   }
}
