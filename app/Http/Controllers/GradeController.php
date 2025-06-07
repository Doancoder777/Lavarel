<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Grade;
use App\Models\Enrollment;
use App\Models\User;
use App\Models\Subject;

class GradeController extends Controller
{
    /**
     * Display grades listing
     */
    public function index(Request $request)
    {
        $query = Grade::with(['enrollment.student', 'enrollment.subject', 'gradedBy']);
        
        // Filter by student
        if ($request->student_id) {
            $query->whereHas('enrollment', function($q) use ($request) {
                $q->where('user_id', $request->student_id);
            });
        }
        
        // Filter by subject
        if ($request->subject_id) {
            $query->whereHas('enrollment', function($q) use ($request) {
                $q->where('subject_id', $request->subject_id);
            });
        }
        
        // Filter by semester
        if ($request->semester) {
            $query->whereHas('enrollment', function($q) use ($request) {
                $q->where('semester', $request->semester);
            });
        }
        
        $grades = $query->orderBy('created_at', 'desc')
            ->paginate(20);
        
        // Get filter options
        $students = User::students()->orderBy('name')->get();
        $subjects = Subject::orderBy('subject_code')->get();
        $semesters = Enrollment::select('semester')
            ->distinct()
            ->orderBy('semester', 'desc')
            ->pluck('semester');
        
        return view('admin.grades.index', compact('grades', 'students', 'subjects', 'semesters'));
    }
    
    /**
     * Show create grade form
     */
    public function create(Request $request)
    {
        // Get enrollments that don't have grades yet
        $query = Enrollment::with(['student', 'subject'])
            ->whereDoesntHave('grade')
            ->where('status', 'completed');
        
        if ($request->student_id) {
            $query->where('user_id', $request->student_id);
        }
        
        if ($request->subject_id) {
            $query->where('subject_id', $request->subject_id);
        }
        
        $enrollments = $query->get();
        
        // If specific enrollment is selected
        $selectedEnrollment = null;
        if ($request->enrollment_id) {
            $selectedEnrollment = Enrollment::with(['student', 'subject'])
                ->find($request->enrollment_id);
        }
        
        $students = User::students()->orderBy('name')->get();
        $subjects = Subject::orderBy('subject_code')->get();
        
        return view('admin.grades.create', compact('enrollments', 'selectedEnrollment', 'students', 'subjects'));
    }
    
    /**
     * Store new grade
     */
    public function store(Request $request)
    {
        $request->validate([
            'enrollment_id' => 'required|exists:enrollments,id',
            'midterm_score' => 'required|numeric|min:0|max:10',
            'final_score' => 'required|numeric|min:0|max:10',
            'assignment_score' => 'required|numeric|min:0|max:10',
            'notes' => 'nullable|string|max:1000'
        ]);
        
        // Check if grade already exists
        $enrollment = Enrollment::find($request->enrollment_id);
        if ($enrollment->grade) {
            return back()->withErrors(['enrollment_id' => 'Điểm cho đăng ký này đã tồn tại']);
        }
        
        // Create grade
        $grade = Grade::create([
            'enrollment_id' => $request->enrollment_id,
            'midterm_score' => $request->midterm_score,
            'final_score' => $request->final_score,
            'assignment_score' => $request->assignment_score,
            'notes' => $request->notes,
            'graded_by' => Auth::id(),
            'graded_at' => now()
        ]);
        
        // The grade calculation is handled automatically by the model
        
        return redirect()->route('admin.grades')
            ->with('success', 'Thêm điểm thành công!');
    }
    
    /**
     * Show edit grade form
     */
    public function edit(Grade $grade)
    {
        $grade->load(['enrollment.student', 'enrollment.subject']);
        
        return view('admin.grades.edit', compact('grade'));
    }
    
    /**
     * Update grade
     */
    public function update(Request $request, Grade $grade)
    {
        $request->validate([
            'midterm_score' => 'required|numeric|min:0|max:10',
            'final_score' => 'required|numeric|min:0|max:10',
            'assignment_score' => 'required|numeric|min:0|max:10',
            'notes' => 'nullable|string|max:1000'
        ]);
        
        $grade->update([
            'midterm_score' => $request->midterm_score,
            'final_score' => $request->final_score,
            'assignment_score' => $request->assignment_score,
            'notes' => $request->notes,
            'graded_by' => Auth::id(),
            'graded_at' => now()
        ]);
        
        return redirect()->route('admin.grades')
            ->with('success', 'Cập nhật điểm thành công!');
    }
    
    /**
     * Delete grade
     */
    public function destroy(Grade $grade)
    {
        $studentName = $grade->enrollment->student->name;
        $subjectName = $grade->enrollment->subject->subject_name;
        
        $grade->delete();
        
        return redirect()->route('admin.grades')
            ->with('success', "Xóa điểm của {$studentName} - {$subjectName} thành công!");
    }
    
    /**
     * Bulk grade entry form
     */
    public function bulkCreate(Request $request)
    {
        $subject = null;
        $enrollments = collect();
        
        if ($request->subject_id) {
            $subject = Subject::find($request->subject_id);
            $enrollments = Enrollment::with(['student'])
                ->where('subject_id', $request->subject_id)
                ->where('status', 'completed')
                ->whereDoesntHave('grade')
                ->orderBy('user_id')
                ->get();
        }
        
        $subjects = Subject::orderBy('subject_code')->get();
        
        return view('admin.grades.bulk-create', compact('subject', 'enrollments', 'subjects'));
    }
    
    /**
     * Store bulk grades
     */
    public function bulkStore(Request $request)
    {
        $request->validate([
            'grades' => 'required|array',
            'grades.*.enrollment_id' => 'required|exists:enrollments,id',
            'grades.*.midterm_score' => 'required|numeric|min:0|max:10',
            'grades.*.final_score' => 'required|numeric|min:0|max:10',
            'grades.*.assignment_score' => 'required|numeric|min:0|max:10',
            'grades.*.notes' => 'nullable|string|max:1000'
        ]);
        
        $created = 0;
        $errors = [];
        
        foreach ($request->grades as $gradeData) {
            $enrollment = Enrollment::find($gradeData['enrollment_id']);
            
            // Check if grade already exists
            if ($enrollment->grade) {
                $errors[] = "Điểm cho {$enrollment->student->name} đã tồn tại";
                continue;
            }
            
            Grade::create([
                'enrollment_id' => $gradeData['enrollment_id'],
                'midterm_score' => $gradeData['midterm_score'],
                'final_score' => $gradeData['final_score'],
                'assignment_score' => $gradeData['assignment_score'],
                'notes' => $gradeData['notes'] ?? null,
                'graded_by' => Auth::id(),
                'graded_at' => now()
            ]);
            
            $created++;
        }
        
        $message = "Thêm {$created} điểm thành công!";
        if (!empty($errors)) {
            $message .= " Lỗi: " . implode(', ', $errors);
        }
        
        return redirect()->route('admin.grades')
            ->with('success', $message);
    }
    
    /**
     * Grade statistics
     */
    public function statistics(Request $request)
    {
        $semester = $request->semester ?? Enrollment::getCurrentSemester();
        
        // Get grades for the semester
        $grades = Grade::whereHas('enrollment', function($q) use ($semester) {
            $q->where('semester', $semester);
        })->with(['enrollment.student', 'enrollment.subject'])->get();
        
        // Calculate statistics
        $stats = [
            'total_grades' => $grades->count(),
            'average_gpa' => round($grades->avg('gpa_value'), 2),
            'grade_distribution' => $grades->groupBy('letter_grade')->map->count(),
            'subject_averages' => $grades->groupBy('enrollment.subject.subject_code')
                ->map(function($subjectGrades) {
                    return [
                        'subject_name' => $subjectGrades->first()->enrollment->subject->subject_name,
                        'average_score' => round($subjectGrades->avg('total_score'), 2),
                        'student_count' => $subjectGrades->count()
                    ];
                })
        ];
        
        $semesters = Enrollment::select('semester')
            ->distinct()
            ->orderBy('semester', 'desc')
            ->pluck('semester');
        
        return view('admin.grades.statistics', compact('stats', 'semester', 'semesters'));
    }
}