<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Enrollment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'user_id',
        'subject_id',
        'semester',
        'enrollment_date',
        'status',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'enrollment_date' => 'datetime',
    ];

    /**
     * Get the student (user) who enrolled
     */
    public function student()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the subject that was enrolled
     */
    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    /**
     * Get the grade for this enrollment
     */
    public function grade()
    {
        return $this->hasOne(Grade::class);
    }

    /**
     * Check if enrollment has grade
     */
    public function hasGrade()
    {
        return $this->grade()->exists();
    }

    /**
     * Get final grade letter
     */
    public function getFinalGradeAttribute()
    {
        return $this->grade ? $this->grade->letter_grade : null;
    }

    /**
     * Get final score
     */
    public function getFinalScoreAttribute()
    {
        return $this->grade ? $this->grade->total_score : null;
    }

    /**
     * Get GPA value
     */
    public function getGpaValueAttribute()
    {
        return $this->grade ? $this->grade->gpa_value : null;
    }

    /**
     * Get enrollment status badge color
     */
    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'enrolled' => 'primary',
            'completed' => 'success', 
            'dropped' => 'danger',
            default => 'secondary'
        };
    }

    /**
     * Get enrollment status in Vietnamese
     */
    public function getStatusTextAttribute()
    {
        return match($this->status) {
            'enrolled' => 'Đang học',
            'completed' => 'Hoàn thành',
            'dropped' => 'Đã bỏ',
            default => 'Không xác định'
        };
    }

    /**
     * Check if enrollment is active (enrolled)
     */
    public function isActive()
    {
        return $this->status === 'enrolled';
    }

    /**
     * Check if enrollment is completed
     */
    public function isCompleted()
    {
        return $this->status === 'completed';
    }

    /**
     * Check if enrollment is dropped
     */
    public function isDropped()
    {
        return $this->status === 'dropped';
    }

    /**
     * Mark enrollment as completed
     */
    public function markAsCompleted()
    {
        $this->update(['status' => 'completed']);
    }

    /**
     * Mark enrollment as dropped
     */
    public function markAsDropped()
    {
        $this->update(['status' => 'dropped']);
    }

    /**
     * Can this enrollment be graded?
     */
    public function canBeGraded()
    {
        return $this->status === 'completed' || $this->status === 'enrolled';
    }

    /**
     * Get semester display format
     */
    public function getSemesterDisplayAttribute()
    {
        // Convert "2024-1" to "Học kỳ 1 năm 2024"
        if (preg_match('/(\d{4})-(\d+)/', $this->semester, $matches)) {
            $year = $matches[1];
            $term = $matches[2];
            return "Học kỳ {$term} năm {$year}";
        }
        
        return $this->semester;
    }

    /**
     * Scope to get enrollments by status
     */
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope to get active enrollments
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'enrolled');
    }

    /**
     * Scope to get completed enrollments
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    /**
     * Scope to get dropped enrollments
     */
    public function scopeDropped($query)
    {
        return $query->where('status', 'dropped');
    }

    /**
     * Scope to get enrollments by semester
     */
    public function scopeBySemester($query, $semester)
    {
        return $query->where('semester', $semester);
    }

    /**
     * Scope to get enrollments by student
     */
    public function scopeByStudent($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Scope to get enrollments by subject
     */
    public function scopeBySubject($query, $subjectId)
    {
        return $query->where('subject_id', $subjectId);
    }

    /**
     * Scope to get enrollments with grades
     */
    public function scopeWithGrades($query)
    {
        return $query->has('grade');
    }

    /**
     * Scope to get enrollments without grades
     */
    public function scopeWithoutGrades($query)
    {
        return $query->doesntHave('grade');
    }

    /**
     * Get current semester (helper method)
     */
    public static function getCurrentSemester()
    {
        $year = date('Y');
        $month = date('n');
        
        // Assuming semester 1 = Jan-Jun, semester 2 = Jul-Dec
        $term = $month <= 6 ? 1 : 2;
        
        return "{$year}-{$term}";
    }

    /**
     * Boot method for auto-setting enrollment date
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($enrollment) {
            if (!$enrollment->enrollment_date) {
                $enrollment->enrollment_date = now();
            }
        });
    }
}