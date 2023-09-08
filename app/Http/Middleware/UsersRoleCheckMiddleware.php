<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class UsersRoleCheckMiddleware {
   /**
    * Handle an incoming request.
    *
    * @param \Illuminate\Http\Request $request
    * @param \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
    * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
    */
   public function handle(Request $request, Closure $next) {
      $admin = auth()->user() ? auth()->user()->isAdmin() : false;
      if ($admin) return $next($request);
      else return redirect()->route("error.no_permission");
   }
}
