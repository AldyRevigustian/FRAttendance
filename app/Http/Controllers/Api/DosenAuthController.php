<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Dosen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class DosenAuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (!Auth::guard('dosen')->attempt($request->only('email', 'password'))) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials do not match our records.'],
            ]);
        }

        $dosen = Dosen::where('email', $request->email)->first();

        if (!$dosen) {
            return response()->json(['message' => 'User not found after authentication.'], 401);
        }

        $token = $dosen->createToken('dosen-api-token')->plainTextToken;

        return response()->json([
            'message' => 'Login successful',
            'user' => $dosen,
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
            'message' => 'Welcome to the Dosen Dashboard!',
            'user' => $request->user(), // The authenticated user instance
        ]);
    }
}
