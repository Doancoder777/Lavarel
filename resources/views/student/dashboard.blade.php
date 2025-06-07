@extends('layouts.student')

@section('title', 'Dashboard')

@section('content')
<div class="welcome-header">
    <div class="row align-items-center">
        <div class="col-md-8">
            <h1 class="mb-2">
                <i class="fas fa-tachometer-alt"></i> Chào mừng trở lại!
            </h1>
            <p class="mb-0 opacity-90">
                <strong>{{ $student->name }}</strong> - Mã SV: {{ $student->student_id }}
            </p>
            <small class="opacity-75">Hôm nay là {{ now()->format('d/m/Y') }}</small>
        </div>
        <div class="col-md-4 text-end">
            <i class="fas fa-graduation-cap fa-4x opacity-50"></i>
        </div>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="text-muted mb-2">Tổng số môn</h6>
                    <div class="stat-number">{{ $stats['total_subjects'] }}</div>
                    <small class="text-muted">môn học</small>
                </div>
                <div class="text-success">
                    <i class="fas fa-book fa-2x opacity-75"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="text-muted mb-2">Đã hoàn thành</h6>
                    <div class="stat-number">{{ $stats['completed_subjects'] }}</div>
                    <small class="text-muted">môn học</small>
                </div>
                <div class="text-primary">
                    <i class="fas fa-check-circle fa-2x opacity-75"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="text-muted mb-2">Đang học</h6>
                    <div class="stat-number">{{ $stats['active_enrollments'] }}</div>
                    <small class="text-muted">môn học</small>
                </div>
                <div class="text-warning">
                    <i class="fas fa-clock fa-2x opacity-75"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="text-muted mb-2">GPA Trung bình</h6>
                    <div class="stat-number">{{ number_format($stats['gpa'], 2) }}</div>
                    <small class="text-muted">/ 4.00</small>
                </div>
                <div class="text-info">
                    <i class="fas fa-chart-line fa-2x opacity-75"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-light border-0">
                <h5 class="mb-0">
                    <i class="fas fa-bolt text-warning"></i> Thao tác nhanh
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <a href="{{ route('student.grades') }}" class="btn btn-outline-success w-100 h-100 d-flex flex-column justify-content-center align-items-center py-3">
                            <i class="fas fa-chart-line fa-2x mb-2"></i>
                            <span>Xem điểm số</span>
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <a href="{{ route('student.enroll.form') }}" class="btn btn-outline-primary w-100 h-100 d-flex flex-column justify-content-center align-items-center py-3">
                            <i class="fas fa-plus-circle fa-2x mb-2"></i>
                            <span>Đăng ký môn học</span>
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <a href="{{ route('student.enrollments') }}" class="btn btn-outline-info w-100 h-100 d-flex flex-column justify-content-center align-items-center py-3">
                            <i class="fas fa-book fa-2x mb-2"></i>
                            <span>Môn đã đăng ký</span>
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <a href="{{ route('student.profile') }}" class="btn btn-outline-secondary w-100 h-100 d-flex flex-column justify-content-center align-items-center py-3">
                            <i class="fas fa-user-edit fa-2x mb-2"></i>
                            <span>Cập nhật hồ sơ</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Activities -->
<div class="row">
    <div class="col-lg-8 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-light border-0">
                <h5 class="mb-0">
                    <i class="fas fa-history text-primary"></i> Hoạt động gần đây
                </h5>
            </div>
            <div class="card-body">
                @if($enrollments->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Môn học</th>
                                    <th>Trạng thái</th>
                                    <th>Điểm</th>
                                    <th>Ngày đăng ký</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($enrollments->take(5) as $enrollment)
                                <tr>
                                    <td>
                                        <strong>{{ $enrollment->subject->subject_code }}</strong><br>
                                        <small class="text-muted">{{ $enrollment->subject->subject_name }}</small>
                                    </td>
                                    <td>
                                        @if($enrollment->status == 'completed')
                                            <span class="badge bg-success">Hoàn thành</span>
                                        @elseif($enrollment->status == 'enrolled')
                                            <span class="badge bg-primary">Đang học</span>
                                        @else
                                            <span class="badge bg-secondary">{{ ucfirst($enrollment->status) }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($enrollment->grade)
                                            <span class="badge badge-grade-{{ substr($enrollment->grade->letter_grade, 0, 1) }}">
                                                {{ $enrollment->grade->letter_grade }}
                                            </span>
                                            <small class="text-muted">({{ $enrollment->grade->total_score }})</small>
                                        @else
                                            <small class="text-muted">Chưa có điểm</small>
                                        @endif
                                    </td>
                                    <td>
                                        <small>{{ $enrollment->created_at->format('d/m/Y') }}</small>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="text-center mt-3">
                        <a href="{{ route('student.enrollments') }}" class="btn btn-outline-primary">
                            <i class="fas fa-eye"></i> Xem tất cả
                        </a>
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                        <h6 class="text-muted">Bạn chưa đăng ký môn học nào</h6>
                        <p class="text-muted">Hãy bắt đầu bằng cách đăng ký môn học đầu tiên!</p>
                        <a href="{{ route('student.enroll.form') }}" class="btn btn-success">
                            <i class="fas fa-plus"></i> Đăng ký ngay
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
    
    <div class="col-lg-4 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-light border-0">
                <h5 class="mb-0">
                    <i class="fas fa-user text-success"></i> Thông tin cá nhân
                </h5>
            </div>
            <div class="card-body">
                <div class="text-center mb-3">
                    <i class="fas fa-user-circle fa-4x text-success mb-2"></i>
                    <h6>{{ $student->name }}</h6>
                    <small class="text-muted">{{ $student->student_id }}</small>
                </div>
                
                <hr>
                
                <div class="mb-2">
                    <i class="fas fa-envelope text-muted me-2"></i>
                    <small>{{ $student->email }}</small>
                </div>
                
                @if($student->phone)
                <div class="mb-2">
                    <i class="fas fa-phone text-muted me-2"></i>
                    <small>{{ $student->phone }}</small>
                </div>
                @endif
                
                @if($student->address)
                <div class="mb-3">
                    <i class="fas fa-map-marker-alt text-muted me-2"></i>
                    <small>{{ $student->address }}</small>
                </div>
                @endif
                
                <div class="text-center">
                    <a href="{{ route('student.profile') }}" class="btn btn-outline-success btn-sm">
                        <i class="fas fa-edit"></i> Chỉnh sửa
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Auto-dismiss alerts after 5 seconds
    setTimeout(function() {
        $('.alert').fadeOut('slow');
    }, 5000);
</script>
@endpush