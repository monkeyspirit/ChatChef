<?php

namespace App\Http\Middleware;

use Closure;

class language
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
        if(session()->has('language')){
            app()->setLocale(session('language'));
        }
        return $next($request);
    }
}
