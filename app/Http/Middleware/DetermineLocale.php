<?php

namespace App\Http\Middleware;

use App\Utils\LocaleUtil;
use Closure;

class DetermineLocale
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $locale = session('locale');

        if (LocaleUtil::isValidLocale($locale)) {
            session(['locale' => $locale]);
            \App::setLocale($locale);
            \Carbon\Carbon::setLocale($locale);
        } else {
            session(['locale' => config('app.fallback_locale')]);
            \App::setLocale(config('app.fallback_locale'));
            \Carbon\Carbon::setLocale(config('app.fallback_locale'));
        }

        return $next($request);
    }
}
