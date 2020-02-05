<?php

namespace App\Http\Middleware;

use Closure;

class PreventBackButton
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
        $responsive = $next($request);
        return $responsive->header('Cache-Control', 'nocache, no-store, max-age=0, max-revalidate')
            ->header('Pragma','no-cache')
            ->header('Expire', 'Sat,01 Jan 1990 00:00:00 GMT');
    }
}
