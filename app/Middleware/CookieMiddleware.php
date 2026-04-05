<?php

namespace App\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Core\Http\Request;
use Core\Middleware\MiddlewareInterface;
use Core\Support\Env;

final class CookieMiddleware implements MiddlewareInterface
{
    public function handle(Request $request, Closure $next)
    {
        $requestUrl = strval(
            $request->server->get(
                'REQUEST_URL',
                $request->server->get('REQUEST_URI', '')
            )
        );

        if (
            strpos($requestUrl, RouteServiceProvider::$API_PREFIX) !== false
            && $requestUrl !== RouteServiceProvider::$API_PREFIX
        ) {
            Env::set('COOKIE', 'false');
        }

        return $next($request);
    }
}
