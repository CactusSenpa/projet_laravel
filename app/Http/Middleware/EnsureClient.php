<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureClient
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->user()?->isClient()) {
            abort(403, 'Accès réservé aux clients.');
        }

        return $next($request);
    }
}
