<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Traits\HttpResponses;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\API\StudentProfileResource;

class StudentAuthController extends Controller
{
    use HttpResponses;

    public function login(Request $request)
    {
        try {
            // Validate the input
            $request->validate([
                'email' => 'required|string',  // We will use 'email' field for both email and student_number
                'password' => 'required|string',
            ]);

            // Retrieve the student by either email or student_number
            $user = \App\Models\Student::where('student_number', $request->email)  // Check if the email provided matches the student_number
                ->first();

            // If no user is found, return an error
            if (!$user) {
                return $this->error(null, 'The provided credentials are incorrect.', 401);
            }

            // Check if the provided password is correct
            if (!Hash::check($request->password, $user->password)) {
                return $this->error(null, 'The provided credentials are incorrect.', 401);
            }

            // Create a token for the authenticated user
            $token = $user->createToken('auth_token')->plainTextToken;

            return $this->success([
                'token' => $token,
                'token_type' => 'Bearer',
                'user' => new StudentProfileResource($user)
            ], 'Login successful');
        } catch (\Exception $e) {
            return $this->error(null, $e->getMessage(), 500);
        }
    }
    //Logout

    public function logout(Request $request)
    {
        // Revoke all tokens for the authenticated user
        $request->user()->tokens()->delete();

        return $this->success([
            'message' => 'Logged out successfully'
        ], 201);
    }
}
