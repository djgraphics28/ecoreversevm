<?php

use App\Http\Controllers\API\StudentAuthController;
use App\Http\Controllers\API\StudentProfileController as StudentProfileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

//STUDENT ROUTES
Route::post('/student/login', [StudentAuthController::class, 'login'])->name('api.student.login');

Route::group(['middleware' => 'auth:sanctum', 'prefix' => 'student'], function() {
    Route::get('/{id}/profile', [StudentProfileController::class, 'getProfile'])->name('api.student.get-profile');
    Route::get('/{id}/profile', [StudentProfileController::class, 'getProfile'])->name('api.student.profile');
    Route::put('/{id}/profile', [StudentProfileController::class, 'updateProfile'])->name('api.student.update.profile');
    Route::put('/{id}/update-password', [StudentProfileController::class, 'updatePassword'])->name('api.student.update.password');
    Route::post('/{id}/upload-profile-picture', [StudentProfileController::class, 'uploadProfilePicture'])->name('api.student.update.profile_picture');
});

//api health check
Route::get('/health-check', function () {
    return response()->json(['message' => 'API is working']);
})->name('api.health-check');
