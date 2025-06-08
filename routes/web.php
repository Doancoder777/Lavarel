<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;  // ← ADDED: Fix for Str::limit() error
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\AdminController;

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
// ADMIN ROUTES - COMPLETE MANAGEMENT SYSTEM
// ============================================
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // Students Management - FULL CRUD
    Route::get('/students', [AdminController::class, 'students'])->name('students');
    Route::get('/students/create', [AdminController::class, 'createStudent'])->name('students.create');
    Route::post('/students', [AdminController::class, 'storeStudent'])->name('students.store');
    Route::get('/students/{user}/edit', [AdminController::class, 'editStudent'])->name('students.edit');
    Route::put('/students/{user}', [AdminController::class, 'updateStudent'])->name('students.update');
    Route::delete('/students/{user}', [AdminController::class, 'deleteStudent'])->name('students.delete');
    
    // Subjects Management - FULL CRUD
    Route::get('/subjects', [AdminController::class, 'subjects'])->name('subjects');
    Route::get('/subjects/create', [AdminController::class, 'createSubject'])->name('subjects.create');
    Route::post('/subjects', [AdminController::class, 'storeSubject'])->name('subjects.store');
    Route::get('/subjects/{subject}/edit', [AdminController::class, 'editSubject'])->name('subjects.edit');
    Route::put('/subjects/{subject}', [AdminController::class, 'updateSubject'])->name('subjects.update');
    Route::delete('/subjects/{subject}', [AdminController::class, 'deleteSubject'])->name('subjects.delete');
    
    // Enrollments Management
    Route::get('/enrollments', [AdminController::class, 'enrollments'])->name('enrollments');
    Route::put('/enrollments/{enrollment}/status', [AdminController::class, 'updateEnrollmentStatus'])->name('enrollments.status');
    
    // Reports & Analytics
    Route::get('/reports', [AdminController::class, 'reports'])->name('reports');
    
    // System Settings
    Route::get('/settings', [AdminController::class, 'settings'])->name('settings');
});

// ============================================
// STUDENT ROUTES - STUDENT PORTAL
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
// QUICK TEST ROUTES (Development)
// ============================================
Route::get('/test-student', function() {
    if (!Auth::check()) return redirect('/login');
    $user = Auth::user();
    if ($user->role !== 'student') return 'Access denied. Admin users should go to /admin/dashboard';
    return redirect()->route('student.dashboard');
});

Route::get('/test-admin', function() {
    if (!Auth::check()) return redirect('/login');
    $user = Auth::user();
    if ($user->role !== 'admin') return 'Access denied. Student users should go to /student/dashboard';
    return redirect()->route('admin.dashboard');
});

// ============================================
// DEBUG & DEVELOPMENT ROUTES
// ============================================
Route::get('/debug', function() {
    return [
        'timestamp' => now()->format('Y-m-d H:i:s'),
        'auth_status' => Auth::check() ? 'Logged in as: ' . Auth::user()->name : 'Not logged in',
        'session_driver' => config('session.driver'),
        'csrf_token' => csrf_token(),
        'current_user' => Auth::user(),
        'admin_routes' => [
            'dashboard' => route('admin.dashboard'),
            'students' => route('admin.students'),
            'students_create' => route('admin.students.create'),
            'subjects' => route('admin.subjects'),
            'subjects_create' => route('admin.subjects.create'),
            'enrollments' => route('admin.enrollments'),
            'reports' => route('admin.reports'),
            'settings' => route('admin.settings'),
        ],
        'student_routes' => [
            'dashboard' => route('student.dashboard'),
            'grades' => route('student.grades'),
            'enrollments' => route('student.enrollments'),
            'enroll_form' => route('student.enroll.form'),
            'profile' => route('student.profile'),
        ],
        'missing_views' => [
            'admin.students.create' => 'resources/views/admin/students/create.blade.php',
            'admin.students.edit' => 'resources/views/admin/students/edit.blade.php',
            'admin.subjects.create' => 'resources/views/admin/subjects/create.blade.php',
            'admin.subjects.edit' => 'resources/views/admin/subjects/edit.blade.php',
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

// Database connection test
Route::get('/test-db', function () {
    try {
        $userCount = \App\Models\User::count();
        $subjectCount = \App\Models\Subject::count();
        $enrollmentCount = \App\Models\Enrollment::count();
        $gradeCount = \App\Models\Grade::count();
        
        return "
        <h2>✅ Database Connection Test</h2>
        <div style='font-family: Arial; padding: 20px; background: #f8f9fa;'>
            <div style='background: white; padding: 20px; border-radius: 10px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);'>
                <h3>📊 Database Statistics:</h3>
                <ul style='list-style: none; padding: 0;'>
                    <li style='padding: 10px; background: #e3f2fd; margin: 5px 0; border-radius: 5px;'>
                        👥 <strong>Users:</strong> {$userCount}
                    </li>
                    <li style='padding: 10px; background: #e8f5e8; margin: 5px 0; border-radius: 5px;'>
                        📚 <strong>Subjects:</strong> {$subjectCount}
                    </li>
                    <li style='padding: 10px; background: #fff3e0; margin: 5px 0; border-radius: 5px;'>
                        📝 <strong>Enrollments:</strong> {$enrollmentCount}
                    </li>
                    <li style='padding: 10px; background: #fce4ec; margin: 5px 0; border-radius: 5px;'>
                        ⭐ <strong>Grades:</strong> {$gradeCount}
                    </li>
                </ul>
                
                <h3>🔗 Quick Links:</h3>
                <div style='margin: 20px 0;'>
                    <a href='/' style='background: #007bff; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; margin: 5px;'>🏠 Home</a>
                    <a href='/debug' style='background: #28a745; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; margin: 5px;'>🔍 Debug</a>
                    <a href='/admin/dashboard' style='background: #dc3545; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; margin: 5px;'>👨‍💼 Admin</a>
                    <a href='/student/dashboard' style='background: #28a745; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; margin: 5px;'>👨‍🎓 Student</a>
                </div>
            </div>
        </div>";
    } catch (Exception $e) {
        return "
        <h2>❌ Database Connection Error</h2>
        <div style='font-family: Arial; padding: 20px; background: #f8f9fa;'>
            <div style='background: #ffebee; padding: 20px; border-radius: 10px; border-left: 4px solid #f44336;'>
                <p><strong>Error:</strong> {$e->getMessage()}</p>
                <p><strong>File:</strong> {$e->getFile()}</p>
                <p><strong>Line:</strong> {$e->getLine()}</p>
                <div style='margin-top: 20px;'>
                    <a href='/' style='background: #007bff; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>🏠 Go Home</a>
                </div>
            </div>
        </div>";
    }
});

// Force logout (for development)
Route::get('/force-logout', function() {
    Auth::logout();
    session()->flush();
    return redirect('/login')->with('success', 'Logged out successfully!');
});

// Route information (Admin only)
Route::get('/routes', function() {
    if (!Auth::check() || Auth::user()->role !== 'admin') {
        abort(403, 'Access denied - Admin only');
    }
    
    $routes = collect(\Illuminate\Support\Facades\Route::getRoutes())->map(function($route) {
        return [
            'method' => implode('|', $route->methods()),
            'uri' => $route->uri(),
            'name' => $route->getName(),
            'action' => $route->getActionName()
        ];
    })->filter(function($route) {
        return !str_contains($route['uri'], '_ignition') && 
               !str_contains($route['uri'], 'telescope') &&
               $route['uri'] !== '/';
    })->sortBy('uri')->values();
    
    $html = "
    <h2>📋 System Routes</h2>
    <div style='font-family: Arial; padding: 20px;'>
        <table border='1' style='width: 100%; border-collapse: collapse;'>
            <tr style='background: #f0f0f0;'>
                <th style='padding: 10px;'>Method</th>
                <th style='padding: 10px;'>URI</th>
                <th style='padding: 10px;'>Name</th>
                <th style='padding: 10px;'>Action</th>
            </tr>";
    
    foreach($routes as $route) {
        $html .= "<tr>
            <td style='padding: 8px;'>{$route['method']}</td>
            <td style='padding: 8px;'>{$route['uri']}</td>
            <td style='padding: 8px;'>{$route['name']}</td>
            <td style='padding: 8px; font-size: 12px;'>" . Str::limit($route['action'], 50) . "</td>
        </tr>";
    }
    
    $html .= "</table><br><a href='/admin/dashboard'>← Back to Admin</a></div>";
    return $html;
})->name('debug.routes');