<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Subject extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'subject_code',
        'subject_name', 
        'credits',
        'description',
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'is_active' => 'boolean',
        'credits' => 'integer',
    ];

    /**
     * Get enrollments for this subject
     */
    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    /**
     * Get students enrolled in this subject
     */
    public function students()
    {
        return $this->belongsToMany(User::class, 'enrollments')
                   ->where('users.role', 'student')
                   ->withPivot('semester', 'status', 'enrollment_date')
                   ->withTimestamps();
    }

    /**
     * Get grades for this subject
     */
    public function grades()
    {
        return $this->hasManyThrough(Grade::class, Enrollment::class);
    }

    /**
     * Get average score for this subject
     */
    public function getAverageScoreAttribute()
    {
        return $this->grades()
                   ->whereNotNull('total_score')
                   ->avg('total_score');
    }

    /**
     * Get total enrolled students
     */
    public function getTotalEnrolledAttribute()
    {
        return $this->enrollments()
                   ->whereIn('status', ['enrolled', 'completed'])
                   ->count();
    }

    /**
     * Get completion rate (%)
     */
    public function getCompletionRateAttribute()
    {
        $total = $this->enrollments()->count();
        if ($total === 0) return 0;
        
        $completed = $this->enrollments()
                         ->where('status', 'completed')
                         ->count();
        
        return round(($completed / $total) * 100, 1);
    }

    /**
     * Scope to get only active subjects
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope to get subjects by credits
     */
    public function scopeByCredits($query, $credits)
    {
        return $query->where('credits', $credits);
    }

    /**
     * Scope to search subjects by code or name
     */
    public function scopeSearch($query, $search)
    {
        return $query->where(function($q) use ($search) {
            $q->where('subject_code', 'LIKE', "%{$search}%")
              ->orWhere('subject_name', 'LIKE', "%{$search}%");
        });
    }
}