<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class GuruAuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (!Auth::guard('guru')->attempt($request->only('email', 'password'))) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials do not match our records.'],
            ]);
        }

        $guru = Guru::where('email', $request->email)->first();

        if (!$guru) {
            return response()->json(['message' => 'User not found after authentication.'], 401);
        }

        $token = $guru->createToken('guru-api-token')->plainTextToken;

        return response()->json([
            'message' => 'Login successful',
            'user' => $guru,
            'token' => $token,
            'token_type' => 'Bearer',
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Successfully logged out']);
    }

    // Example of a protected route method
    public function dashboard(Request $request)
    {
        return response()->json([
            'message' => 'Welcome to the Guru Dashboard!',
            'user' => $request->user(), // The authenticated user instance
        ]);
    }
}
