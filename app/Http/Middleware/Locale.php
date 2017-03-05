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
        $language = null;

        if (\Auth::guest()) {
            // Overwrite locale
            if ($request->has('locale')) {
                session(['locale' => $request->locale]);
            } 
            
            // Default locale
            if (session('locale') == null) {
                session(['locale' => \Config::get('app.locale')]);
            }
            
            $language = session('locale');
        } else {
            $language = \Auth::user()->lang_pref;
        }
      
        \App::setLocale($language);
      
        return $next($request);
    }
}
