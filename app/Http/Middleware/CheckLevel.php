<?php

namespace App\Http\Middleware;

use Closure;

class CheckLevel
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $privilege)
    {
      
        if($privilege == 'admin' && auth()->user()->level == 'admin'){
            return $next($request);
        }else if($privilege == 'petugas' && auth()->user()->level == 'petugas'){       
            return $next($request);
        }else if($privilege == 'admin&petugas'){
            if(auth()->user()->level == 'admin'){
                  return $next($request);
             }else if(auth()->user()->level == 'petugas'){
                  return $next($request);
             }
        }
          
        return back();
    }
}
