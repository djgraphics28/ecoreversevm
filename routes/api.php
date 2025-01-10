<?php

use App\Http\Controllers\API\AdminController;
use App\Http\Controllers\API\StudentAuthController;
use App\Http\Controllers\API\StudentProfileController as StudentProfileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/student-info/{rfid}',[StudentProfileController::class, 'getStudentInfoByRfid']);
Route::put('/redeem/{rfid}',[StudentProfileController::class, 'redeem']);

//STUDENT ROUTES
Route::post('/student/login', [StudentAuthController::class, 'login'])->name('api.student.login');

Route::group(['middleware' => 'auth:sanctum', 'prefix' => 'student'], function() {
    Route::get('/profile', [StudentProfileController::class, 'getProfile'])->name('api.student.get-profile');
    Route::get('/profile', [StudentProfileController::class, 'getProfile'])->name('api.student.profile');
    Route::put('/profile', [StudentProfileController::class, 'updateProfile'])->name('api.student.update.profile');
    Route::put('/update-password', [StudentProfileController::class, 'updatePassword'])->name('api.student.update.password');
    Route::post('/upload-profile-picture', [StudentProfileController::class, 'uploadProfilePicture'])->name('api.student.update.profile_picture');
    Route::get('/points', [StudentProfileController::class, 'getPoints']);

});

Route::post('/admin/login', [AdminController::class, 'login'])->name('api.admin.login');

Route::group(['middleware' => 'auth:sanctum', 'prefix' => 'admin'], function() {

    Route::post('/logout', [AdminController::class, 'logout'])->name('api.admin.logout');
    Route::get('/profile', [AdminController::class, 'getProfile'])->name('api.admin.get-profile');
    Route::put('/profile', [AdminController::class, 'updateProfile'])->name('api.admin.update.profile');
    Route::get('/students',[AdminController::class, 'getStudentList'])->name('api.admin.student-list');
    Route::get('/student/{id}', [AdminController::class, 'getStudentById'])->name('api.admin.student');
    Route::delete('/student/{id}', [AdminController::class, 'deleteStudent'])->name('api.admin.delete.student');
    Route::get('/sections', [AdminController::class, 'getSectionList'])->name('api.admin.sections');
    Route::get('/faculties',[AdminController::class, 'getFaculties'])->name('api.admin.faculties');
    Route::get('/faculty/{id}', [AdminController::class, 'getFacultyById'])->name('api.admin.faculty');
    Route::get('/notifications', [AdminController::class, 'getNotifications'])->name('api.admin.notifications');
    Route::get('/missions', [AdminController::class, 'getMissionVision'])->name('api.admin.missions');
});

Route::post('/student/insert-object/{rfidCode}', [StudentProfileController::class, 'insertObjectAndCreatePoints']);

//api health check
Route::get('/health-check', function () {
    return response()->json(['message' => 'API is working']);
})->name('api.health-check');
