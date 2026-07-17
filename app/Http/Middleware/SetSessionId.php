<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetSessionId
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->cookie('session_id')) {
            $sessionId = \Illuminate\Support\Str::uuid()->toString();
            cookie()->queue('session_id', $sessionId, 60 * 24 * 365); // 1 year
        }

        return $next($request);
    }
}