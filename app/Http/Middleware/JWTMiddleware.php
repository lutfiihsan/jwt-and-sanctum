<?php

namespace App\Http\Middleware;

use Closure;
use Carbon\Carbon;
use App\Models\Token;
use Illuminate\Http\Request;

class JWTMiddleware
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
        // Get the token from the request header
        $token = $request->bearerToken();

        // Check if the token exists in the database
        $savedToken = Token::where('token', $token)->first();

        if (!$savedToken) {
            return response()->json(['error' => 'Invalid token'], 401);
        }

        // Verify the token payload
        $payload = json_decode($savedToken->payload, true);

        $domain = 'abc.com'; // ganti dengan domain website Anda
        if ($payload['iss'] !== $domain) {
            return response()->json(['error' => 'Invalid token'], 401);
        }

        $api_key = '123';
        $generatedToken = hash('sha256', $api_key . $savedToken->payload);
        if ($generatedToken !== $savedToken->token) {
            return response()->json(['error' => 'Invalid token'], 401);
        }

        $exp = Carbon::createFromTimestamp($payload['exp']);
        // Check if the token has expired
        if ($exp->isPast()) {
            return response()->json(['error' => 'Token has expired'], 401);
        }

        // Pass the validated token to the next request handler
        $request->attributes->add(['token' => $savedToken]);

        return $next($request);
    }
}
