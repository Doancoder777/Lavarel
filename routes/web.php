<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\AdminController; // THÊM IMPORT

/*
|--------------------------------------------------------------------------
| Web Routes - Student Management System
|--------------------------------------------------------------------------
*/

// Home route
Route::get('/', function () {
    if (Auth::check()) {
        $user = Auth::user();
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        } elseif ($user->role === 'student') {
            return redirect()->route('student.dashboard');
        }
    }
    return redirect()->route('login');
})->name('home');

// Authentication routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ============================================
// ADMIN ROUTES - SỬ DỤNG CONTROLLER
// ============================================
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // Students Management
    Route::get('/students', [AdminController::class, 'students'])->name('students');
    Route::get('/students/create', [AdminController::class, 'createStudent'])->name('students.create');
    Route::post('/students', [AdminController::class, 'storeStudent'])->name('students.store');
    Route::get('/students/{user}/edit', [AdminController::class, 'editStudent'])->name('students.edit');
    Route::put('/students/{user}', [AdminController::class, 'updateStudent'])->name('students.update');
    Route::delete('/students/{user}', [AdminController::class, 'deleteStudent'])->name('students.delete');
    
    // Subjects Management
    Route::get('/subjects', [AdminController::class, 'subjects'])->name('subjects');
    Route::get('/subjects/create', [AdminController::class, 'createSubject'])->name('subjects.create');
    Route::post('/subjects', [AdminController::class, 'storeSubject'])->name('subjects.store');
    Route::get('/subjects/{subject}/edit', [AdminController::class, 'editSubject'])->name('subjects.edit');
    Route::put('/subjects/{subject}', [AdminController::class, 'updateSubject'])->name('subjects.update');
    Route::delete('/subjects/{subject}', [AdminController::class, 'deleteSubject'])->name('subjects.delete');
    
    // Enrollments Management
    Route::get('/enrollments', [AdminController::class, 'enrollments'])->name('enrollments');
    Route::put('/enrollments/{enrollment}/status', [AdminController::class, 'updateEnrollmentStatus'])->name('enrollments.status');
});

// ============================================
// STUDENT ROUTES
// ============================================
Route::middleware(['auth', 'role:student'])->prefix('student')->name('student.')->group(function () {
    
    // Student Dashboard
    Route::get('/dashboard', [StudentController::class, 'dashboard'])->name('dashboard');
    
    // Grades Management
    Route::get('/grades', [StudentController::class, 'showGrades'])->name('grades');
    
    // Enrollments Management
    Route::get('/enrollments', [StudentController::class, 'showEnrollments'])->name('enrollments');
    Route::get('/enroll', [StudentController::class, 'showEnrollmentForm'])->name('enroll.form');
    Route::post('/enroll', [StudentController::class, 'processEnrollment'])->name('enroll.process');
    Route::post('/enrollments/{id}/drop', [StudentController::class, 'dropEnrollment'])->name('enrollment.drop');
    
    // Profile Management
    Route::get('/profile', [StudentController::class, 'showProfile'])->name('profile');
    Route::post('/profile', [StudentController::class, 'updateProfile'])->name('profile.update');
});

// ============================================
// DEBUG & TEST ROUTES
// ============================================
Route::get('/debug', function() {
    return [
        'auth_status' => Auth::check() ? 'Logged in as: ' . Auth::user()->name : 'Not logged in',
        'session_driver' => config('session.driver'),
        'csrf_token' => csrf_token(),
        'current_user' => Auth::user(),
        'available_routes' => [
            'home' => route('home'),
            'login' => route('login'),
            'admin.dashboard' => route('admin.dashboard'),
            'admin.students' => route('admin.students'),
            'admin.subjects' => route('admin.subjects'),
            'student.dashboard' => route('student.dashboard'),
            'student.grades' => route('student.grades'),
        ]
    ];
});

Route::post('/test-post', function(\Illuminate\Http\Request $request) {
    return [
        'message' => 'POST request received successfully',
        'form_data' => $request->all(),
        'ip' => $request->ip(),
        'timestamp' => now()
    ];
});

// Test database
Route::get('/test-db', function () {
    try {
        $userCount = \App\Models\User::count();
        $subjectCount = \App\Models\Subject::count();
        return "<h2>Database Test</h2><p>✅ Users: {$userCount}</p><p>✅ Subjects: {$subjectCount}</p><a href='/'>Home</a>";
    } catch (Exception $e) {
        return "<h2>Database Error</h2><p>❌ {$e->getMessage()}</p>";
    }
});