<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Grade extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'enrollment_id',
        'midterm_score',
        'final_score',
        'assignment_score',
        'total_score',
        'letter_grade',
        'gpa_value',
        'notes',
        'graded_by',
        'graded_at',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'midterm_score' => 'decimal:2',
        'final_score' => 'decimal:2',
        'assignment_score' => 'decimal:2',
        'total_score' => 'decimal:2',
        'gpa_value' => 'decimal:2',
        'graded_at' => 'datetime',
    ];

    /**
     * Get the enrollment that owns the grade
     */
    public function enrollment()
    {
        return $this->belongsTo(Enrollment::class);
    }

    /**
     * Get the admin who graded this
     */
    public function gradedBy()
    {
        return $this->belongsTo(User::class, 'graded_by');
    }

    /**
     * Get the student through enrollment
     */
    public function student()
    {
        return $this->hasOneThrough(User::class, Enrollment::class, 'id', 'id', 'enrollment_id', 'user_id');
    }

    /**
     * Get the subject through enrollment
     */
    public function subject()
    {
        return $this->hasOneThrough(Subject::class, Enrollment::class, 'id', 'id', 'enrollment_id', 'subject_id');
    }

    /**
     * Calculate total score automatically
     * Formula: 30% midterm + 50% final + 20% assignment
     */
    public function calculateTotalScore()
    {
        if ($this->midterm_score && $this->final_score && $this->assignment_score) {
            $total = ($this->midterm_score * 0.3) + 
                    ($this->final_score * 0.5) + 
                    ($this->assignment_score * 0.2);
            
            $this->total_score = round($total, 2);
            $this->setLetterGradeAndGpa();
            
            return $this->total_score;
        }
        
        return null;
    }

    /**
     * Set letter grade and GPA based on total score
     */
    public function setLetterGradeAndGpa()
    {
        if (!$this->total_score) return;

        $score = $this->total_score;

        if ($score >= 9.0) {
            $this->letter_grade = 'A';
            $this->gpa_value = 4.00;
        } elseif ($score >= 8.5) {
            $this->letter_grade = 'A-';
            $this->gpa_value = 3.70;
        } elseif ($score >= 8.0) {
            $this->letter_grade = 'B+';
            $this->gpa_value = 3.50;
        } elseif ($score >= 7.0) {
            $this->letter_grade = 'B';
            $this->gpa_value = 3.00;
        } elseif ($score >= 6.5) {
            $this->letter_grade = 'C+';
            $this->gpa_value = 2.50;
        } elseif ($score >= 5.5) {
            $this->letter_grade = 'C';
            $this->gpa_value = 2.00;
        } elseif ($score >= 4.0) {
            $this->letter_grade = 'D+';
            $this->gpa_value = 1.50;
        } elseif ($score >= 3.0) {
            $this->letter_grade = 'D';
            $this->gpa_value = 1.00;
        } else {
            $this->letter_grade = 'F';
            $this->gpa_value = 0.00;
        }
    }

    /**
     * Get academic performance level
     */
    public function getPerformanceLevelAttribute()
    {
        if (!$this->gpa_value) return 'Chưa có điểm';

        if ($this->gpa_value >= 3.7) return 'Xuất sắc';
        if ($this->gpa_value >= 3.0) return 'Khá';
        if ($this->gpa_value >= 2.0) return 'Trung bình';
        return 'Yếu';
    }

    /**
     * Get grade color for UI
     */
    public function getGradeColorAttribute()
    {
        if (!$this->letter_grade) return 'secondary';

        return match($this->letter_grade) {
            'A', 'A-' => 'success',
            'B+', 'B' => 'primary',
            'C+', 'C' => 'warning',
            'D+', 'D' => 'orange',
            'F' => 'danger',
            default => 'secondary'
        };
    }

    /**
     * Check if grade is passing
     */
    public function isPassing()
    {
        return $this->gpa_value >= 1.0;
    }

    /**
     * Scope to get excellent grades (A, A-)
     */
    public function scopeExcellent($query)
    {
        return $query->whereIn('letter_grade', ['A', 'A-']);
    }

    /**
     * Scope to get failing grades (F)
     */
    public function scopeFailing($query)
    {
        return $query->where('letter_grade', 'F');
    }

    /**
     * Scope to get grades by semester
     */
    public function scopeBySemester($query, $semester)
    {
        return $query->whereHas('enrollment', function($q) use ($semester) {
            $q->where('semester', $semester);
        });
    }

    /**
     * Boot method to auto-calculate scores
     */
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($grade) {
            // Auto-calculate total score when saving
            if ($grade->midterm_score && $grade->final_score && $grade->assignment_score) {
                $grade->calculateTotalScore();
                $grade->graded_at = now();
            }
        });
    }
}