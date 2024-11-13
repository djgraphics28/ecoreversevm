<?php

namespace App\Http\Controllers\API;

use App\Models\Student;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\API\StudentProfileResource;

class StudentProfileController extends Controller
{
    public function getProfile(Request $request, $id)
    {
        // Get the authenticated user using the ParentPal model
        $user = Student::find($id);

        return response()->json([
            'status' => 'success',
            'data' => New StudentProfileResource($user) // Returns all user data
        ]);
    }

    public function updateProfile(Request $request, $id)
    {
        // Get the authenticated user using the ParentPal model
        $user = Student::find($id);

        // Update the user's profile with the request data
        $user->update($request->all());

        return response()->json([
            'status' => 'success',
            'message' => 'Profile updated successfully',
            'data' => $user
        ]);
    }

    //updatePassword
    public function updatePassword(Request $request, $id)
    {
        // Get the authenticated user using the ParentPal model
        $user = Student::find($id);


        // Check if the current password matches
        if (!password_verify($request->currentPassword, $user->password)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Current password is incorrect'
            ], 401);
        }

        // Update the user's password
        $user->update([
            'password' => bcrypt($request->newPassword)
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Password updated successfully'
        ]);
    }

    public function uploadProfilePicture(Request $request, $id)
    {
        // Get the authenticated user or find by ID
        $user = Student::find($id);

        // Validate the incoming request
        $request->validate([
            'profile_picture' => 'required|image|mimes:jpg,jpeg,png|max:2048', // Adjust rules as necessary
        ]);

        // Handle file upload using Media Library
        if ($request->hasFile('profile_picture')) {
            // Clear the existing media in the avatars collection if necessary
            if ($user->hasMedia('student_pictures')) {
                $user->clearMediaCollection('student_pictures');
            }

            // Add the new profile picture to the avatars collection
            $user->addMedia($request->file('profile_picture'))->toMediaCollection('student_pictures');
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Profile picture updated successfully',
            'data' => [
                'profilePicture' => $user->getFirstMediaUrl('student_pictures'), // Get the URL of the uploaded image
            ]
        ]);
    }
}