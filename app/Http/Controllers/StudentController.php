<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Subject;
use App\Models\Enrollment;
use App\Models\Grade;

class StudentController extends Controller
{
    /**
     * Student dashboard
     */
    public function dashboard()
    {
        /** @var User $student */
        $student = Auth::user();
        
        if ($student->role !== 'student') {
            abort(403, 'Access denied');
        }
        
        // Get student's enrollments with subjects and grades
        $studentEnrollments = Enrollment::where('user_id', $student->id)
            ->with(['subject', 'grade'])
            ->orderBy('created_at', 'desc')
            ->get();
        
        // Calculate statistics
        $totalSubjects = $studentEnrollments->count();
        $completedSubjects = $studentEnrollments->where('status', 'completed')->count();
        $activeEnrollments = $studentEnrollments->where('status', 'enrolled')->count();
        
        // Calculate GPA
        $completedGrades = $studentEnrollments
            ->where('status', 'completed')
            ->filter(function($enrollment) {
                return $enrollment->grade && $enrollment->grade->gpa_value;
            });
        
        $gpa = $completedGrades->count() > 0 
            ? round($completedGrades->avg('grade.gpa_value'), 2)
            : 0;
        
        $data = [
            'student' => $student,
            'enrollments' => $studentEnrollments,
            'stats' => [
                'total_subjects' => $totalSubjects,
                'completed_subjects' => $completedSubjects,
                'active_enrollments' => $activeEnrollments,
                'gpa' => $gpa
            ]
        ];
        
        return view('student.dashboard', $data);
    }
    
    /**
     * Show student's grades
     */
    public function showGrades()
    {
        /** @var User $student */
        $student = Auth::user();
        
        if ($student->role !== 'student') {
            abort(403, 'Access denied');
        }
        
        $studentEnrollments = Enrollment::where('user_id', $student->id)
            ->with(['subject', 'grade'])
            ->where('status', 'completed')
            ->whereHas('grade')
            ->get();
        
        return view('student.grades', [
            'student' => $student, 
            'enrollments' => $studentEnrollments
        ]);
    }
    
    /**
     * Show student's enrollments
     */
    public function showEnrollments()
    {
        /** @var User $student */
        $student = Auth::user();
        
        if ($student->role !== 'student') {
            abort(403, 'Access denied');
        }
        
        $studentEnrollments = Enrollment::where('user_id', $student->id)
            ->with(['subject', 'grade'])
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('student.enrollments', [
            'student' => $student, 
            'enrollments' => $studentEnrollments
        ]);
    }
    
    /**
     * Show enrollment form
     */
    public function showEnrollmentForm()
    {
        /** @var User $student */
        $student = Auth::user();
        
        if ($student->role !== 'student') {
            abort(403, 'Access denied');
        }
        
        // Get subjects not yet enrolled by student
        $enrolledSubjectIds = Enrollment::where('user_id', $student->id)
            ->pluck('subject_id')
            ->toArray();
        
        $availableSubjects = Subject::where('is_active', true)
            ->whereNotIn('id', $enrolledSubjectIds)
            ->orderBy('subject_code')
            ->get();
        
        return view('student.enroll', [
            'student' => $student, 
            'availableSubjects' => $availableSubjects
        ]);
    }
    
    /**
     * Process enrollment
     */
    public function processEnrollment(Request $request)
    {
        /** @var User $student */
        $student = Auth::user();
        
        if ($student->role !== 'student') {
            abort(403, 'Access denied');
        }
        
        $request->validate([
            'subject_id' => 'required|exists:subjects,id'
        ]);
        
        $subjectId = $request->subject_id;
        
        // Check if already enrolled
        $existingEnrollment = Enrollment::where('user_id', $student->id)
            ->where('subject_id', $subjectId)
            ->first();
        
        if ($existingEnrollment) {
            return back()->withErrors(['subject_id' => 'Bạn đã đăng ký môn học này rồi']);
        }
        
        // Get current semester (simple logic)
        $year = date('Y');
        $month = date('n');
        $term = $month <= 6 ? 1 : 2;
        $currentSemester = "{$year}-{$term}";
        
        // Create enrollment
        $enrollment = Enrollment::create([
            'user_id' => $student->id,
            'subject_id' => $subjectId,
            'semester' => $currentSemester,
            'status' => 'enrolled'
        ]);
        
        $subject = Subject::find($subjectId);
        
        return redirect()->route('student.enrollments')
            ->with('success', "Đăng ký môn {$subject->subject_name} thành công!");
    }
    
    /**
     * Drop enrollment
     */
    public function dropEnrollment($enrollmentId)
    {
        /** @var User $student */
        $student = Auth::user();
        
        if ($student->role !== 'student') {
            abort(403, 'Access denied');
        }
        
        /** @var Enrollment $enrollment */
        $enrollment = Enrollment::find($enrollmentId);
        
        if (!$enrollment) {
            abort(404);
        }
        
        // Check if enrollment belongs to student
        if ($enrollment->user_id !== $student->id) {
            abort(403, 'Không có quyền truy cập');
        }
        
        // Cannot drop completed subjects
        if ($enrollment->status === 'completed') {
            return back()->withErrors(['error' => 'Không thể hủy môn học đã hoàn thành']);
        }
        
        $subjectName = $enrollment->subject->subject_name;
        $enrollment->update(['status' => 'dropped']);
        
        return back()->with('success', "Đã hủy đăng ký môn {$subjectName}");
    }
    
    /**
     * Show student profile
     */
    public function showProfile()
    {
        /** @var User $student */
        $student = Auth::user();
        
        if ($student->role !== 'student') {
            abort(403, 'Access denied');
        }
        
        return view('student.profile', ['student' => $student]);
    }
    
    /**
     * Update student profile
     */
    public function updateProfile(Request $request)
    {
        /** @var User $student */
        $student = Auth::user();
        
        if ($student->role !== 'student') {
            abort(403, 'Access denied');
        }
        
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'current_password' => 'nullable|string',
            'new_password' => 'nullable|string|min:6|confirmed'
        ]);
        
        // Update basic info
        $student->update([
            'name' => $request->name,
            'phone' => $request->phone,
            'address' => $request->address
        ]);
        
        // Update password if provided
        if ($request->current_password && $request->new_password) {
            if (!Hash::check($request->current_password, $student->password)) {
                return back()->withErrors(['current_password' => 'Mật khẩu hiện tại không chính xác']);
            }
            
            $student->update([
                'password' => Hash::make($request->new_password)
            ]);
            
            return back()->with('success', 'Cập nhật thông tin và mật khẩu thành công!');
        }
        
        return back()->with('success', 'Cập nhật thông tin thành công!');
    }
}