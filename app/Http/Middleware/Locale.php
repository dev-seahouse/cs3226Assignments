<?php

namespace App\Http\Middleware;

use Closure;

class Locale
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
        if (\Auth::guest()) {
            $language = \Config::get('app.locale');
        } else {
            $language = \Auth::user()->lang_pref;
        }
      
        \App::setLocale($language);
      
        return $next($request);
    }
}
