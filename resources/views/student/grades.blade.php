@extends('layouts.student')

@section('title', 'Xem điểm số')

@section('content')
<div class="welcome-header">
    <div class="row align-items-center">
        <div class="col-md-8">
            <h1 class="mb-2">
                <i class="fas fa-chart-line"></i> Bảng điểm của tôi
            </h1>
            <p class="mb-0 opacity-90">
                Xem điểm số các môn học đã hoàn thành
            </p>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('student.dashboard') }}" class="btn btn-light btn-lg">
                <i class="fas fa-arrow-left"></i> Về Dashboard
            </a>
        </div>
    </div>
</div>

<!-- Statistics -->
<div class="row mb-4">
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="text-muted mb-2">Môn đã có điểm</h6>
                    <div class="stat-number">{{ $enrollments->count() }}</div>
                    <small class="text-muted">môn học</small>
                </div>
                <div class="text-success">
                    <i class="fas fa-check-circle fa-2x opacity-75"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="text-muted mb-2">GPA Trung bình</h6>
                    <div class="stat-number">
                        @if($enrollments->count() > 0)
                            {{ number_format($enrollments->avg('grade.gpa_value'), 2) }}
                        @else
                            0.00
                        @endif
                    </div>
                    <small class="text-muted">/ 4.00</small>
                </div>
                <div class="text-primary">
                    <i class="fas fa-star fa-2x opacity-75"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="text-muted mb-2">Điểm cao nhất</h6>
                    <div class="stat-number">
                        @if($enrollments->count() > 0)
                            {{ number_format($enrollments->max('grade.total_score'), 1) }}
                        @else
                            0.0
                        @endif
                    </div>
                    <small class="text-muted">/ 10.0</small>
                </div>
                <div class="text-warning">
                    <i class="fas fa-arrow-up fa-2x opacity-75"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="text-muted mb-2">Tổng tín chỉ</h6>
                    <div class="stat-number">
                        {{ $enrollments->sum('subject.credits') }}
                    </div>
                    <small class="text-muted">tín chỉ</small>
                </div>
                <div class="text-info">
                    <i class="fas fa-graduation-cap fa-2x opacity-75"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Grades Table -->
<div class="card border-0 shadow-sm">
    <div class="card-header bg-light border-0">
        <h5 class="mb-0">
            <i class="fas fa-table text-primary"></i> Chi tiết điểm số
        </h5>
    </div>
    <div class="card-body p-0">
        @if($enrollments->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-success">
                        <tr>
                            <th class="ps-4">Môn học</th>
                            <th class="text-center">Tín chỉ</th>
                            <th class="text-center">Điểm GK</th>
                            <th class="text-center">Điểm CK</th>
                            <th class="text-center">Điểm BT</th>
                            <th class="text-center">Điểm TB</th>
                            <th class="text-center">Điểm chữ</th>
                            <th class="text-center">GPA</th>
                            <th class="text-center">Xếp loại</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($enrollments as $enrollment)
                        <tr>
                            <td class="ps-4">
                                <div>
                                    <strong class="text-primary">{{ $enrollment->subject->subject_code }}</strong>
                                    <br>
                                    <small class="text-muted">{{ $enrollment->subject->subject_name }}</small>
                                </div>
                            </td>
                            <td class="text-center">
                                <span class="badge bg-secondary">{{ $enrollment->subject->credits }}</span>
                            </td>
                            <td class="text-center">
                                @if($enrollment->grade && $enrollment->grade->midterm_score)
                                    <span class="fw-bold">{{ number_format($enrollment->grade->midterm_score, 1) }}</span>
                                @else
                                    <small class="text-muted">--</small>
                                @endif
                            </td>
                            <td class="text-center">
                                @if($enrollment->grade && $enrollment->grade->final_score)
                                    <span class="fw-bold">{{ number_format($enrollment->grade->final_score, 1) }}</span>
                                @else
                                    <small class="text-muted">--</small>
                                @endif
                            </td>
                            <td class="text-center">
                                @if($enrollment->grade && $enrollment->grade->assignment_score)
                                    <span class="fw-bold">{{ number_format($enrollment->grade->assignment_score, 1) }}</span>
                                @else
                                    <small class="text-muted">--</small>
                                @endif
                            </td>
                            <td class="text-center">
                                @if($enrollment->grade && $enrollment->grade->total_score)
                                    <span class="fw-bold fs-5 
                                        @if($enrollment->grade->total_score >= 8.5) text-success
                                        @elseif($enrollment->grade->total_score >= 7.0) text-primary  
                                        @elseif($enrollment->grade->total_score >= 5.5) text-warning
                                        @else text-danger @endif">
                                        {{ number_format($enrollment->grade->total_score, 1) }}
                                    </span>
                                @else
                                    <small class="text-muted">--</small>
                                @endif
                            </td>
                            <td class="text-center">
                                @if($enrollment->grade && $enrollment->grade->letter_grade)
                                    <span class="badge badge-grade-{{ substr($enrollment->grade->letter_grade, 0, 1) }} fs-6">
                                        {{ $enrollment->grade->letter_grade }}
                                    </span>
                                @else
                                    <small class="text-muted">--</small>
                                @endif
                            </td>
                            <td class="text-center">
                                @if($enrollment->grade && $enrollment->grade->gpa_value)
                                    <span class="fw-bold">{{ number_format($enrollment->grade->gpa_value, 2) }}</span>
                                @else
                                    <small class="text-muted">--</small>
                                @endif
                            </td>
                            <td class="text-center">
                                @if($enrollment->grade && $enrollment->grade->gpa_value)
                                    @if($enrollment->grade->gpa_value >= 3.7)
                                        <span class="badge bg-success">Xuất sắc</span>
                                    @elseif($enrollment->grade->gpa_value >= 3.0)
                                        <span class="badge bg-primary">Khá</span>
                                    @elseif($enrollment->grade->gpa_value >= 2.0)
                                        <span class="badge bg-warning">Trung bình</span>
                                    @else
                                        <span class="badge bg-danger">Yếu</span>
                                    @endif
                                @else
                                    <small class="text-muted">--</small>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Summary Footer -->
            <div class="card-footer bg-light">
                <div class="row text-center">
                    <div class="col-md-3">
                        <strong class="text-success">Tổng tín chỉ:</strong> 
                        {{ $enrollments->sum('subject.credits') }}
                    </div>
                    <div class="col-md-3">
                        <strong class="text-primary">GPA tích lũy:</strong> 
                        @if($enrollments->count() > 0)
                            {{ number_format($enrollments->avg('grade.gpa_value'), 2) }}
                        @else
                            0.00
                        @endif
                    </div>
                    <div class="col-md-3">
                        <strong class="text-warning">Điểm TB:</strong> 
                        @if($enrollments->count() > 0)
                            {{ number_format($enrollments->avg('grade.total_score'), 1) }}
                        @else
                            0.0
                        @endif
                    </div>
                    <div class="col-md-3">
                        <strong class="text-info">Xếp loại chung:</strong> 
                        @php 
                            $avgGpa = $enrollments->count() > 0 ? $enrollments->avg('grade.gpa_value') : 0; 
                        @endphp
                        @if($avgGpa >= 3.7) 
                            Xuất sắc
                        @elseif($avgGpa >= 3.0) 
                            Khá  
                        @elseif($avgGpa >= 2.0) 
                            Trung bình
                        @else 
                            Yếu 
                        @endif
                    </div>
                </div>
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-chart-line fa-4x text-muted mb-3"></i>
                <h5 class="text-muted">Chưa có điểm số nào</h5>
                <p class="text-muted mb-4">Bạn chưa hoàn thành môn học nào hoặc chưa được chấm điểm</p>
                <a href="{{ route('student.enrollments') }}" class="btn btn-success me-2">
                    <i class="fas fa-book"></i> Xem môn đã đăng ký
                </a>
                <a href="{{ route('student.enroll.form') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Đăng ký môn học
                </a>
            </div>
        @endif
    </div>
</div>
@endsection