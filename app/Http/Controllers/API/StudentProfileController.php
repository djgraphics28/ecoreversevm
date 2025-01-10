<?php

namespace App\Http\Controllers\API;

use App\Models\Student;
use Illuminate\Http\Request;
use App\Models\InsertObjectHistory;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Mail\InsertObjectNotification;
use App\Http\Resources\StudentInfoResource;
use App\Http\Resources\API\StudentProfileResource;

class StudentProfileController extends Controller
{
    public function getProfile(Request $request)
    {
        // Get the authenticated user using the ParentPal model
        $user = $request->user();

        return response()->json([
            'status' => 'success',
            'data' => new StudentProfileResource($user) // Returns all user data
        ]);
    }

    public function updateProfile(Request $request)
    {
        // Get the authenticated user using the ParentPal model
        $user = $request->user();

        // Update the user's profile with the request data
        $user->update($request->all());

        return response()->json([
            'status' => 'success',
            'message' => 'Profile updated successfully',
            'data' => $user
        ]);
    }

    //updatePassword
    public function updatePassword(Request $request)
    {
        // Get the authenticated user using the ParentPal model
        $user = $request->user();


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

    public function uploadProfilePicture(Request $request)
    {
        // Get the authenticated user or find by ID
        $user = $request->user();

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

    public function getStudentInfoByRfid($rfid)
    {
        $student = Student::where('rfid_code', $rfid)->first();

        if (!$student) {
            return response()->json([
                'status' => 'error',
                'message' => 'Student not found'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => new StudentInfoResource($student)
        ]);
    }

    public function getPoints(Request $request)
    {
        try {
            $user = Student::find($request->user()->id);
            return response()->json([
                'status' => 'success',
                'points' => $user->points
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error retrieving points: ' . $e->getMessage()
            ], 500);
        }
    }

    public function redeem(Request $request, $rfidCode)
    {
        $student = Student::where('rfid_code', $rfidCode)->first();
        if (!$student) {
            return response()->json([
                'status' => 'error',
                'message' => 'Student not found'
            ], 404);
        }

        // Validate points to deduct
        if (!$request->has('deduct') || !is_numeric($request->deduct) || $request->deduct <= 0) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid points amount'
            ], 400);
        }

        // Check if student has enough points
        if ($student->points < $request->deduct) {
            return response()->json([
                'status' => 'error',
                'message' => 'Insufficient points'
            ], 400);
        }

        $deductedPoints = $student->points - $request->deduct;
        $student->update(['points' => $deductedPoints]);

        return response()->json([
            'status' => 'success',
            'message' => 'Points deducted successfully',
            'data' => [
                'previous_points' => $student->points + $request->deduct,
                'deducted_points' => $request->deduct,
                'current_points' => $deductedPoints
            ]
        ]);
    }

    public function insertObjectAndCreatePoints(Request $request, $rfidCode)
    {
        try {
            $student = Student::where('rfid_code', $rfidCode)->first();
            $points = 0;
            if (!$student) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Student not found'
                ], 404);
            }
            $object = $request->input('object');
            if ($object == "plastic") {
                $points = 5;
            } elseif ($object == "metal") {
                $points = 10;
            } else {
                $points = 0;
            }

            $student->points += $points;
            $student->save();

            if ($object !== "trash") {
                // Create history record for the inserted object
                InsertObjectHistory::create([
                    'student_id' => $student->id,
                    'object_inserted' => $object,
                    'points' => $points
                ]);

                // Get student's history of inserted objects
                $histories = InsertObjectHistory::where('student_id', $student->id)
                    ->orderBy('created_at', 'desc')
                    ->get();

                try {
                    // Send notification email with object and points details
                    Mail::to('darwin.ibay30@gmail.com')->send(new InsertObjectNotification([
                        'student_name' => $student->name,
                        'object' => $object,
                        'points' => $points,
                        'total_points' => $student->points,
                        'histories' => $histories
                    ]));
                } catch (\Exception $e) {
                    \Log::error('Failed to send insert object notification email: ' . $e->getMessage());
                }
            }
            return response()->json([
                'status' => 'success',
                'message' => $object == "trash" ? 'No Points added' : 'Points added successfully',
                'points' => $student->points
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error adding points: ' . $e->getMessage()
            ], 500);
        }
    }
}
