@extends('layouts.admin')

@section('title', 'Báo cáo Thống kê')
@section('page-title', 'Báo cáo Thống kê')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h4 class="mb-0">
                                <i class="fas fa-chart-bar me-2 text-primary"></i>
                                Báo cáo Thống kê Hệ thống
                            </h4>
                            <small class="text-muted">Tổng quan và phân tích dữ liệu - Cập nhật: {{ now()->format('d/m/Y H:i') }}</small>
                        </div>
                        <div class="col-md-4 text-end">
                            <div class="btn-group">
                                <button class="btn btn-outline-success btn-sm" onclick="window.print()">
                                    <i class="fas fa-print me-1"></i>
                                    In báo cáo
                                </button>
                                <button class="btn btn-outline-primary btn-sm" disabled title="Tính năng sắp có">
                                    <i class="fas fa-download me-1"></i>
                                    Xuất PDF
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Overview Statistics -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100 border-start border-primary border-4">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <div class="text-xs fw-bold text-primary text-uppercase mb-1">Tổng Sinh viên</div>
                            <div class="h4 mb-0 fw-bold">{{ $totalStudents }}</div>
                            <small class="text-success">
                                <i class="fas fa-arrow-up"></i> Đang hoạt động
                            </small>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-graduate fa-2x text-primary"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100 border-start border-success border-4">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <div class="text-xs fw-bold text-success text-uppercase mb-1">Tổng Môn học</div>
                            <div class="h4 mb-0 fw-bold">{{ $totalSubjects }}</div>
                            <small class="text-info">
                                <i class="fas fa-book"></i> Đa dạng chuyên ngành
                            </small>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-book fa-2x text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100 border-start border-info border-4">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <div class="text-xs fw-bold text-info text-uppercase mb-1">Tổng Đăng ký</div>
                            <div class="h4 mb-0 fw-bold">{{ $totalEnrollments }}</div>
                            <small class="text-warning">
                                <i class="fas fa-clipboard-list"></i> Tất cả học kỳ
                            </small>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clipboard-list fa-2x text-info"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100 border-start border-warning border-4">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <div class="text-xs fw-bold text-warning text-uppercase mb-1">Tỷ lệ Hoàn thành</div>
                            <div class="h4 mb-0 fw-bold">
                                @if($totalEnrollments > 0)
                                    {{ round(($completedEnrollments / $totalEnrollments) * 100, 1) }}%
                                @else
                                    0%
                                @endif
                            </div>
                            <small class="text-success">
                                <i class="fas fa-percentage"></i> {{ $completedEnrollments }}/{{ $totalEnrollments }}
                            </small>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-chart-pie fa-2x text-warning"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="row mb-4">
        <!-- Enrollments by Semester -->
        <div class="col-lg-6 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom">
                    <h6 class="mb-0">
                        <i class="fas fa-calendar-alt me-2 text-primary"></i>
                        Đăng ký theo Học kỳ
                    </h6>
                </div>
                <div class="card-body">
                    @if($enrollmentsBySemester->count() > 0)
                        <div class="chart-container">
                            @foreach($enrollmentsBySemester as $index => $item)
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <div>
                                        <span class="fw-medium">Học kỳ {{ $item->semester }}</span>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <div class="progress me-3" style="width: 200px; height: 20px;">
                                            @if($index == 0)
                                                <div class="progress-bar bg-primary" style="width: 85%"></div>
                                            @elseif($index == 1)
                                                <div class="progress-bar bg-primary" style="width: 65%"></div>
                                            @elseif($index == 2)
                                                <div class="progress-bar bg-primary" style="width: 45%"></div>
                                            @else
                                                <div class="progress-bar bg-primary" style="width: 25%"></div>
                                            @endif
                                        </div>
                                        <span class="badge bg-primary">{{ $item->total }}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center text-muted py-4">
                            <i class="fas fa-chart-bar fa-3x mb-3"></i>
                            <p>Chưa có dữ liệu đăng ký</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Grade Distribution -->
        <div class="col-lg-6 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom">
                    <h6 class="mb-0">
                        <i class="fas fa-star me-2 text-warning"></i>
                        Phân bố Điểm số
                    </h6>
                </div>
                <div class="card-body">
                    @if($gradeDistribution->count() > 0)
                        <div class="chart-container">
                            @foreach($gradeDistribution as $grade)
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <div>
                                        @if($grade->letter_grade == 'A' || $grade->letter_grade == 'A-')
                                            <span class="badge bg-success me-2">{{ $grade->letter_grade }}</span>
                                            <span class="fw-medium">Xuất sắc</span>
                                        @elseif(in_array($grade->letter_grade, ['B+', 'B']))
                                            <span class="badge bg-primary me-2">{{ $grade->letter_grade }}</span>
                                            <span class="fw-medium">Khá</span>
                                        @elseif(in_array($grade->letter_grade, ['C+', 'C']))
                                            <span class="badge bg-info me-2">{{ $grade->letter_grade }}</span>
                                            <span class="fw-medium">Trung bình</span>
                                        @elseif(in_array($grade->letter_grade, ['D+', 'D']))
                                            <span class="badge bg-warning me-2">{{ $grade->letter_grade }}</span>
                                            <span class="fw-medium">Yếu</span>
                                        @else
                                            <span class="badge bg-danger me-2">{{ $grade->letter_grade }}</span>
                                            <span class="fw-medium">Kém</span>
                                        @endif
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <div class="progress me-3" style="width: 150px; height: 20px;">
                                            @if($grade->letter_grade == 'A')
                                                <div class="progress-bar bg-success" style="width: 80%"></div>
                                            @elseif($grade->letter_grade == 'A-')
                                                <div class="progress-bar bg-success" style="width: 70%"></div>
                                            @elseif($grade->letter_grade == 'B+')
                                                <div class="progress-bar bg-primary" style="width: 60%"></div>
                                            @elseif($grade->letter_grade == 'B')
                                                <div class="progress-bar bg-primary" style="width: 50%"></div>
                                            @elseif($grade->letter_grade == 'C+')
                                                <div class="progress-bar bg-info" style="width: 40%"></div>
                                            @elseif($grade->letter_grade == 'C')
                                                <div class="progress-bar bg-info" style="width: 30%"></div>
                                            @elseif($grade->letter_grade == 'D+')
                                                <div class="progress-bar bg-warning" style="width: 20%"></div>
                                            @elseif($grade->letter_grade == 'D')
                                                <div class="progress-bar bg-warning" style="width: 15%"></div>
                                            @else
                                                <div class="progress-bar bg-danger" style="width: 10%"></div>
                                            @endif
                                        </div>
                                        <span class="text-muted">{{ $grade->count }}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center text-muted py-4">
                            <i class="fas fa-star fa-3x mb-3"></i>
                            <p>Chưa có dữ liệu điểm số</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Top Subjects -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom">
                    <h6 class="mb-0">
                        <i class="fas fa-trophy me-2 text-warning"></i>
                        Top 10 Môn học Phổ biến
                    </h6>
                </div>
                <div class="card-body">
                    @if($topSubjects->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th width="10%">Xếp hạng</th>
                                        <th width="15%">Mã môn</th>
                                        <th width="40%">Tên môn học</th>
                                        <th width="10%">Tín chỉ</th>
                                        <th width="15%">Số đăng ký</th>
                                        <th width="10%">Tỷ lệ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($topSubjects as $index => $subject)
                                        <tr>
                                            <td>
                                                @if($index == 0)
                                                    <span class="badge bg-warning"><i class="fas fa-crown"></i> #{{ $index + 1 }}</span>
                                                @elseif($index == 1)
                                                    <span class="badge bg-secondary"><i class="fas fa-medal"></i> #{{ $index + 1 }}</span>
                                                @elseif($index == 2)
                                                    <span class="badge bg-info"><i class="fas fa-award"></i> #{{ $index + 1 }}</span>
                                                @else
                                                    <span class="badge bg-light text-dark">#{{ $index + 1 }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="badge bg-primary">{{ $subject->subject_code }}</span>
                                            </td>
                                            <td>{{ $subject->subject_name }}</td>
                                            <td>
                                                <span class="badge bg-info">{{ $subject->credits }}</span>
                                            </td>
                                            <td>
                                                <strong>{{ $subject->enrollments_count }}</strong>
                                            </td>
                                            <td>
                                                <small class="text-muted">
                                                    @if($totalEnrollments > 0)
                                                        {{ round(($subject->enrollments_count / $totalEnrollments) * 100, 1) }}%
                                                    @else
                                                        0%
                                                    @endif
                                                </small>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center text-muted py-4">
                            <i class="fas fa-book fa-3x mb-3"></i>
                            <p>Chưa có dữ liệu môn học</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
@media print {
    .btn-group, .sidebar {
        display: none !important;
    }
    .main-content {
        margin-left: 0 !important;
    }
}
</style>
@endsection