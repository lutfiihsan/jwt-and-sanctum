<?php

namespace App\Http\Controllers;

use App\Models\Token;
use Dotenv\Parser\Value;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use PHPOpenSourceSaver\JWTAuth\JWTGuard;
use Illuminate\Support\Facades\Validator;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class TokenController extends Controller
{
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'api_key' => 'required',
            'domain' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()
            ], 400);
        }

        $payload = [
            'iss' => $request->domain,
            'iat' => time(),
            'exp' => strtotime('+1 hour'),
        ];

        $token = hash('sha256', $request->api_key . json_encode($payload));

        // Insert the token into the database
        $newToken = Token::create([
            'token' => $token,
            'payload' => json_encode($payload),
        ]);

        // Return the token to the client
        return response()->json(['token' => $newToken->token]);
    }

    public function validateToken(Request $request)
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

        $exp = date('Y-m-d H:i:s', $payload['exp']);
        // Check if the token has expired
        if (strtotime($exp) < time()) {
            return response()->json(['error' => 'Token has expired'], 401);
        }

        // If everything is valid, return success message
        return response()->json(['message' => 'Valid token'], 200);
    }
}
