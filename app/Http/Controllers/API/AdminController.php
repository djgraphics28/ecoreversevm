<?php

namespace App\Http\Controllers\API;

use App\Models\Faculty;
use App\Models\Section;
use App\Models\Student;
use Illuminate\Http\Request;
use App\Traits\HttpResponses;
use App\Http\Controllers\Controller;
use App\Http\Resources\FacultyResource;
use App\Models\MissionVision;

class AdminController extends Controller
{
    use HttpResponses;
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (auth()->attempt($credentials)) {
            $user = auth()->user();

            $token = $user->createToken('authToken')->plainTextToken;

            $user->profilePic = $user->getFirstMediaUrl('profile_pictures');

            return $this->success([
                'token' => $token,
                'token_type' => 'Bearer',
                'profile' => $user,
            ], 'Login successful');
        }

        return response()->json(['error' => 'Invalid credentials'], 401);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return $this->success(null, 'Logout successful');
    }

    public function getProfile(Request $request)
    {
        $user = $request->user();

        if (!$user->is_admin) {
            return $this->success(['user' => $user, 'facultyInfo' => $user->facultyInfo], 'Profile retrieved successfully');
        } else {
            return $this->success($user, 'Profile retrieved successfully');
        }
    }

    public function updateProfile(Request $request)
    {
        $user = $request->user();

        $user->update($request->all());

        return $this->success($user, 'Profile updated successfully');
    }

    public function updatePassword(Request $request)
    {
        $user = $request->user();

        $user->update([
            'password' => bcrypt($request->password),
        ]);

        return $this->success(null, 'Password updated successfully');
    }

    public function getStudentList(Request $request)
    {
        if($request->user()->is_admin) {
            $students = Student::all();
        } else {
            $sectionIds = Section::where('faculty_id', $request->user()->facultyInfo->id)->pluck('id');
            $students = Student::whereIn('section_id', $sectionIds)->get();
        }

        $students->each(function($student) {
            $student->profilePic = $student->getFirstMediaUrl('student_pictures');
        });

        return $this->success($students, 'Student list retrieved successfully', 200);
    }

    public function getStudentById(Request $request, $id)
    {
        $student = Student::find($id);

        if (!$student) {
            return $this->error(null, 'Student not found', 404);
        }

        return $this->success($student, 'Student retrieved successfully');
    }

    public function updateStudent(Request $request, $id)
    {
        $student = Student::find($id);

        if (!$student) {
            return $this->error(null, 'Student not found', 404);
        }

        $student->update($request->all());

        return $this->success($student, 'Student updated successfully');
    }

    public function deleteStudent(Request $request, $id)
    {
        $student = Student::find($id);

        if (!$student) {
            return $this->error(null, 'Student not found', 404);
        }

        $student->delete();

        return $this->success(null, 'Student deleted successfully');
    }

    public function getSectionList(Request $request)
    {
        $sections = Section::all();

        return $this->success($sections, 'Section list retrieved successfully');
    }

    public function getFaculties(Request $request)
    {
        $faculties = Faculty::all();

        // $faculties->each(function($faculty) {
        //     $faculty->profilePic = $faculty->getFirstMediaUrl('profile');
        // });

        return $this->success(FacultyResource::collection($faculties), 'Faculty list retrieved successfully');
    }

    public function getFacultyById(Request $request, $id)
    {
        $faculty = Faculty::find($id);

        if (!$faculty) {
            return $this->error(null, 'Faculty not found', 404);
        }

        return $this->success($faculty, 'Faculty retrieved successfully');
    }

    public function getNotifications(Request $request)
    {
        $notifications = $request->user()->notifications;

        return $this->success($notifications, 'Notifications retrieved successfully');
    }

    public function getMissionVision(Request $request)
    {
        $data = MissionVision::find(1);
        $missionVision = [
            'mission' => $data->mission_text,
            'vision' => $data->vision_text,
        ];

        return $this->success($missionVision, 'Mission vision retrieved successfully');
    }
}
