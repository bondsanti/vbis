<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // ตรวจสอบ Token ที่ส่งมากับคำขอ
        $token = $request->header('Authorization');

        if ($token !== 'Bearer 1|LcbxpDu7J2Dj2DkRlAKM6649tSSdwuJtKfcoSQhR') {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $next($request);
    }
}
