<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Livewire\Users\Index as UserIndex;
use App\Livewire\Users\Create as UserCreate;
use App\Livewire\Users\Edit as UserEdit;

use App\Livewire\Roles\Index as RolesIndex;
use App\Livewire\Roles\Create as RolesCreate;
use App\Livewire\Roles\Edit as RolesEdit;

use App\Livewire\GradeLevel\Index as GradeLevelIndex;
use App\Livewire\GradeLevel\Create as GradeLevelCreate;
use App\Livewire\GradeLevel\Edit as GradeLevelEdit;

use App\Livewire\Section\Index as SectionIndex;
use App\Livewire\Section\Create as SectionCreate;
use App\Livewire\Section\Edit as SectionEdit;

use App\Livewire\Students\Index as StudentsIndex;
use App\Livewire\Students\Create as StudentsCreate;
use App\Livewire\Students\Edit as StudentsEdit;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    // Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::middleware('permission:access users')->group(function () {
        Route::get('/users', UserIndex::class)->name('users.index');
        Route::get('/users/create', UserCreate::class)->name('users.create');
        Route::get('/users/{user}/edit', UserEdit::class)->name('users.edit');
    });

    Route::middleware('permission:access roles')->group(function () {
        Route::get('roles', RolesIndex::class)->name('roles.index');
        Route::get('roles/create', RolesCreate::class)->name('roles.create');
        Route::get('roles/{roleId}/edit', RolesEdit::class)->name('roles.edit');
    });

    Route::middleware('permission:access grade level')->group(function () {
        Route::get('grade-levels', GradeLevelIndex::class)->name('grade-levels.index');
        Route::get('grade-levels/create', GradeLevelCreate::class)->name('grade-levels.create');
        Route::get('grade-levels/{gradeLevelId}/edit', GradeLevelEdit::class)->name('grade-levels.edit');
    });

    Route::middleware('permission:access section')->group(function () {
        Route::get('sections', SectionIndex::class)->name('sections.index');
        Route::get('sections/create', SectionCreate::class)->name('sections.create');
        Route::get('sections/{sectionId}/edit', SectionEdit::class)->name('sections.edit');
    });

    Route::middleware('permission:access students')->group(function () {
        Route::get('students', StudentsIndex::class)->name('students.index');
        Route::get('students/create', StudentsCreate::class)->name('students.create');
        Route::get('students/{studentId}/edit', StudentsEdit::class)->name('students.edit');
    });
});

require __DIR__.'/auth.php';
