<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Auth;

use Closure;

class CheckAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

      $response = $next($request);
      var_dump($request->user()->is_admin);
      //var_dump(\Auth::user());

      //exit;
        // if (!Auth::user()->is_admin) {
        //     return redirect('bus-search');
        // }

        return $response;
    }
}
