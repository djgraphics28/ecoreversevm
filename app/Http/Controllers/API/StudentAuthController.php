<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Traits\HttpResponses;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\API\StudentProfileResource;

class StudentAuthController extends Controller
{
    use HttpResponses;

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        // Attempt to authenticate the student
        if (!Auth::guard('student')->attempt($request->only('email', 'password'))) {
            return $this->error(null, 'The provided credentials are incorrect.', 401);
        }

        // Get the authenticated student
        $user = Auth::guard('student')->user();

        // Create a token for the authenticated user
        $token = $user->createToken('auth_token')->plainTextToken;

        return $this->success([
            'token' => $token,
            'token_type' => 'Bearer',
            'user' => New StudentProfileResource($user)
        ], 'Login successful');
    }
}
