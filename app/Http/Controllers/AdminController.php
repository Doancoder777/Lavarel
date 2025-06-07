<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Subject;
use App\Models\Enrollment;
use App\Models\Grade;

class AdminController extends Controller
{
    /**
     * Admin dashboard
     */
    public function dashboard()
    {
        $admin = Auth::user();
        
        // Get statistics
        $totalStudents = User::students()->count();
        $totalSubjects = Subject::count();
        $totalEnrollments = Enrollment::count();
        $activeEnrollments = Enrollment::active()->count();
        
        // Recent activities
        $recentEnrollments = Enrollment::with(['student', 'subject'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
        
        $recentGrades = Grade::with(['enrollment.student', 'enrollment.subject'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
        
        $data = [
            'admin' => $admin,
            'stats' => [
                'total_students' => $totalStudents,
                'total_subjects' => $totalSubjects,
                'total_enrollments' => $totalEnrollments,
                'active_enrollments' => $activeEnrollments
            ],
            'recent_enrollments' => $recentEnrollments,
            'recent_grades' => $recentGrades
        ];
        
        return view('admin.dashboard', $data);
    }
    
    /**
     * Students management
     */
    public function students(Request $request)
    {
        $query = User::students();
        
        // Search functionality
        if ($request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%")
                  ->orWhere('student_id', 'LIKE', "%{$search}%");
            });
        }
        
        $students = $query->withCount('enrollments')
            ->orderBy('created_at', 'desc')
            ->paginate(15);
        
        return view('admin.students.index', compact('students'));
    }
    
    /**
     * Show create student form
     */
    public function createStudent()
    {
        return view('admin.students.create');
    }
    
    /**
     * Store new student
     */
    public function storeStudent(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'student_id' => 'required|string|max:20|unique:users,student_id',
            'password' => 'required|string|min:6|confirmed',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500'
        ]);
        
        $student = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'student_id' => $request->student_id,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'address' => $request->address,
            'role' => 'student'
        ]);
        
        return redirect()->route('admin.students')
            ->with('success', "Thêm sinh viên {$student->name} thành công!");
    }
    
    /**
     * Show edit student form
     */
    public function editStudent(User $user)
    {
        if ($user->role !== 'student') {
            abort(404);
        }
        
        return view('admin.students.edit', compact('user'));
    }
    
    /**
     * Update student
     */
    public function updateStudent(Request $request, User $user)
    {
        if ($user->role !== 'student') {
            abort(404);
        }
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'student_id' => 'required|string|max:20|unique:users,student_id,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'new_password' => 'nullable|string|min:6|confirmed'
        ]);
        
        $updateData = [
            'name' => $request->name,
            'email' => $request->email,
            'student_id' => $request->student_id,
            'phone' => $request->phone,
            'address' => $request->address
        ];
        
        if ($request->new_password) {
            $updateData['password'] = Hash::make($request->new_password);
        }
        
        $user->update($updateData);
        
        return redirect()->route('admin.students')
            ->with('success', "Cập nhật thông tin sinh viên {$user->name} thành công!");
    }
    
    /**
     * Delete student
     */
    public function deleteStudent(User $user)
    {
        if ($user->role !== 'student') {
            abort(404);
        }
        
        $name = $user->name;
        $user->delete();
        
        return redirect()->route('admin.students')
            ->with('success', "Xóa sinh viên {$name} thành công!");
    }
    
    /**
     * Subjects management
     */
    public function subjects(Request $request)
    {
        $query = Subject::query();
        
        if ($request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('subject_code', 'LIKE', "%{$search}%")
                  ->orWhere('subject_name', 'LIKE', "%{$search}%");
            });
        }
        
        $subjects = $query->withCount('enrollments')
            ->orderBy('subject_code')
            ->paginate(15);
        
        return view('admin.subjects.index', compact('subjects'));
    }
    
    /**
     * Show create subject form
     */
    public function createSubject()
    {
        return view('admin.subjects.create');
    }
    
    /**
     * Store new subject
     */
    public function storeSubject(Request $request)
    {
        $request->validate([
            'subject_code' => 'required|string|max:20|unique:subjects,subject_code',
            'subject_name' => 'required|string|max:255',
            'credits' => 'required|integer|min:1|max:10',
            'description' => 'nullable|string',
            'is_active' => 'boolean'
        ]);
        
        $subject = Subject::create([
            'subject_code' => $request->subject_code,
            'subject_name' => $request->subject_name,
            'credits' => $request->credits,
            'description' => $request->description,
            'is_active' => $request->boolean('is_active', true)
        ]);
        
        return redirect()->route('admin.subjects')
            ->with('success', "Thêm môn học {$subject->subject_name} thành công!");
    }
    
    /**
     * Show edit subject form
     */
    public function editSubject(Subject $subject)
    {
        return view('admin.subjects.edit', compact('subject'));
    }
    
    /**
     * Update subject
     */
    public function updateSubject(Request $request, Subject $subject)
    {
        $request->validate([
            'subject_code' => 'required|string|max:20|unique:subjects,subject_code,' . $subject->id,
            'subject_name' => 'required|string|max:255',
            'credits' => 'required|integer|min:1|max:10',
            'description' => 'nullable|string',
            'is_active' => 'boolean'
        ]);
        
        $subject->update([
            'subject_code' => $request->subject_code,
            'subject_name' => $request->subject_name,
            'credits' => $request->credits,
            'description' => $request->description,
            'is_active' => $request->boolean('is_active')
        ]);
        
        return redirect()->route('admin.subjects')
            ->with('success', "Cập nhật môn học {$subject->subject_name} thành công!");
    }
    
    /**
     * Delete subject
     */
    public function deleteSubject(Subject $subject)
    {
        $name = $subject->subject_name;
        $subject->delete();
        
        return redirect()->route('admin.subjects')
            ->with('success', "Xóa môn học {$name} thành công!");
    }
    
    /**
     * Enrollments management
     */
    public function enrollments(Request $request)
    {
        $query = Enrollment::with(['student', 'subject']);
        
        if ($request->status) {
            $query->where('status', $request->status);
        }
        
        if ($request->semester) {
            $query->where('semester', $request->semester);
        }
        
        $enrollments = $query->orderBy('created_at', 'desc')
            ->paginate(20);
        
        $semesters = Enrollment::select('semester')
            ->distinct()
            ->orderBy('semester', 'desc')
            ->pluck('semester');
        
        return view('admin.enrollments.index', compact('enrollments', 'semesters'));
    }
    
    /**
     * Update enrollment status
     */
    public function updateEnrollmentStatus(Request $request, Enrollment $enrollment)
    {
        $request->validate([
            'status' => 'required|in:enrolled,completed,dropped'
        ]);
        
        $enrollment->update(['status' => $request->status]);
        
        return back()->with('success', 'Cập nhật trạng thái đăng ký thành công!');
    }
}