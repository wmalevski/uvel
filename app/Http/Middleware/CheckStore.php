<?php

namespace App\Http\Middleware;

use Closure;
use App\UserSubstitution;
use Illuminate\Support\Facades\Auth;

class CheckStore
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
        if(Auth::user()){
            $substitution = UserSubstitution::where([
                ['user_id', '=', Auth::user()->id],
                ['date_to', '>=', date("Y-m-d")]
            ])->first();

            if($substitution){
                Auth::user()->store = $substitution->store_id;
            }
        }
        

        return $next($request);
    }
}
