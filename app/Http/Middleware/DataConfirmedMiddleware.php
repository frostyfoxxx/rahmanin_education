<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class DataConfirmedMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param $bool
     * @return mixed
     */
    public function handle(Request $request, Closure $next, bool $bool)
    {
        if (auth('sanctum')->user()->data_confirmed == $bool) {
            return response()->json([
                'error' => [
                    'code' => 403,
                    'message' => "Вы не можете изменять данные, так как они уже подтверждены",
                ]
            ], 403);
        }
        return $next($request);
    }
}
