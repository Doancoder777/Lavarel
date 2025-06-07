@extends('layouts.student')

@section('title', 'Môn đã đăng ký')

@section('content')
<div class="welcome-header">
    <div class="row align-items-center">
        <div class="col-md-8">
            <h1 class="mb-2">
                <i class="fas fa-book"></i> Môn học đã đăng ký
            </h1>
            <p class="mb-0 opacity-90">
                Quản lý các môn học bạn đã đăng ký
            </p>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('student.enroll.form') }}" class="btn btn-light btn-lg">
                <i class="fas fa-plus"></i> Đăng ký thêm
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
                    <h6 class="text-muted mb-2">Tổng môn đăng ký</h6>
                    <div class="stat-number">{{ $enrollments->count() }}</div>
                    <small class="text-muted">môn học</small>
                </div>
                <div class="text-primary">
                    <i class="fas fa-book fa-2x opacity-75"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="text-muted mb-2">Đang học</h6>
                    <div class="stat-number">{{ $enrollments->where('status', 'enrolled')->count() }}</div>
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
                    <h6 class="text-muted mb-2">Đã hoàn thành</h6>
                    <div class="stat-number">{{ $enrollments->where('status', 'completed')->count() }}</div>
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
                    <h6 class="text-muted mb-2">Đã hủy</h6>
                    <div class="stat-number">{{ $enrollments->where('status', 'dropped')->count() }}</div>
                    <small class="text-muted">môn học</small>
                </div>
                <div class="text-danger">
                    <i class="fas fa-times-circle fa-2x opacity-75"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Enrollments List -->
<div class="card border-0 shadow-sm">
    <div class="card-header bg-light border-0">
        <h5 class="mb-0">
            <i class="fas fa-list text-primary"></i> Danh sách môn học
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
                            <th class="text-center">Học kỳ</th>
                            <th class="text-center">Trạng thái</th>
                            <th class="text-center">Điểm</th>
                            <th class="text-center">Ngày đăng ký</th>
                            <th class="text-center">Thao tác</th>
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
                                    @if($enrollment->subject->description)
                                    <br>
                                    <small class="text-info">{{ $enrollment->subject->description }}</small>
                                    @endif
                                </div>
                            </td>
                            <td class="text-center">
                                <span class="badge bg-secondary">{{ $enrollment->subject->credits }} TC</span>
                            </td>
                            <td class="text-center">
                                <span class="badge bg-info">{{ $enrollment->semester }}</span>
                            </td>
                            <td class="text-center">
                                @if($enrollment->status == 'enrolled')
                                    <span class="badge bg-warning">
                                        <i class="fas fa-clock"></i> Đang học
                                    </span>
                                @elseif($enrollment->status == 'completed')
                                    <span class="badge bg-success">
                                        <i class="fas fa-check"></i> Hoàn thành
                                    </span>
                                @elseif($enrollment->status == 'dropped')
                                    <span class="badge bg-danger">
                                        <i class="fas fa-times"></i> Đã hủy
                                    </span>
                                @endif
                            </td>
                            <td class="text-center">
                                @if($enrollment->grade)
                                    <div>
                                        <span class="badge badge-grade-{{ substr($enrollment->grade->letter_grade, 0, 1) }} fs-6">
                                            {{ $enrollment->grade->letter_grade }}
                                        </span>
                                        <br>
                                        <small class="text-muted">({{ number_format($enrollment->grade->total_score, 1) }})</small>
                                    </div>
                                @else
                                    <small class="text-muted">Chưa có điểm</small>
                                @endif
                            </td>
                            <td class="text-center">
                                <small>{{ $enrollment->created_at->format('d/m/Y') }}</small>
                            </td>
                            <td class="text-center">
                                @if($enrollment->status == 'enrolled')
                                    <form method="POST" action="{{ route('student.enrollment.drop', $enrollment->id) }}" style="display: inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-outline-danger btn-sm" 
                                                onclick="return confirm('Bạn có chắc muốn hủy đăng ký môn {{ $enrollment->subject->subject_name }}?')">
                                            <i class="fas fa-times"></i> Hủy
                                        </button>
                                    </form>
                                @elseif($enrollment->status == 'completed')
                                    <a href="{{ route('student.grades') }}" class="btn btn-outline-primary btn-sm">
                                        <i class="fas fa-eye"></i> Xem điểm
                                    </a>
                                @else
                                    <small class="text-muted">--</small>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-book-open fa-4x text-muted mb-3"></i>
                <h5 class="text-muted">Chưa đăng ký môn học nào</h5>
                <p class="text-muted mb-4">Hãy bắt đầu hành trình học tập của bạn!</p>
                <a href="{{ route('student.enroll.form') }}" class="btn btn-success btn-lg">
                    <i class="fas fa-plus"></i> Đăng ký môn học ngay
                </a>
            </div>
        @endif
    </div>
</div>
@endsection