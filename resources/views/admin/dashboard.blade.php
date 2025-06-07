@extends('layouts.admin')

@section('title', 'Admin Dashboard')
@section('page-title', 'Dashboard')

@section('breadcrumb')
    <li class="breadcrumb-item active">Dashboard</li>
@endsection

@section('content')
<div class="container-fluid">
    <!-- Welcome Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="admin-card card">
                <div class="card-body bg-gradient text-white" style="background: linear-gradient(135deg, #dc3545 0%, #a71e2a 100%);">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h2 class="mb-2">
                                <i class="fas fa-shield-halved me-2"></i>
                                Chào mừng Admin!
                            </h2>
                            <p class="mb-0 h5">{{ $admin->name }}</p>
                            <small class="opacity-75">{{ $admin->email }}</small>
                        </div>
                        <div class="col-md-4 text-end">
                            <div class="fs-1 opacity-50">
                                <i class="fas fa-user-shield"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="admin-card card stat-card h-100">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <div class="text-xs fw-bold text-primary text-uppercase mb-1">
                                Tổng Sinh viên
                            </div>
                            <div class="h5 mb-0 fw-bold text-gray-800">
                                {{ $stats['total_students'] }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-graduate fa-2x text-primary"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="admin-card card stat-card h-100">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <div class="text-xs fw-bold text-success text-uppercase mb-1">
                                Tổng Môn học
                            </div>
                            <div class="h5 mb-0 fw-bold text-gray-800">
                                {{ $stats['total_subjects'] }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-book fa-2x text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="admin-card card stat-card h-100">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <div class="text-xs fw-bold text-info text-uppercase mb-1">
                                Tổng Đăng ký
                            </div>
                            <div class="h5 mb-0 fw-bold text-gray-800">
                                {{ $stats['total_enrollments'] }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clipboard-list fa-2x text-info"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="admin-card card stat-card h-100">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <div class="text-xs fw-bold text-warning text-uppercase mb-1">
                                Đăng ký Đang hoạt động
                            </div>
                            <div class="h5 mb-0 fw-bold text-gray-800">
                                {{ $stats['active_enrollments'] }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clock fa-2x text-warning"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="admin-card card">
                <div class="card-header bg-white">
                    <h5 class="mb-0">
                        <i class="fas fa-bolt me-2"></i>
                        Thao tác nhanh
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('admin.students.create') }}" class="btn btn-admin w-100 py-3">
                                <i class="fas fa-user-plus d-block mb-2"></i>
                                Thêm Sinh viên
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('admin.subjects.create') }}" class="btn btn-outline-primary w-100 py-3">
                                <i class="fas fa-book-medical d-block mb-2"></i>
                                Thêm Môn học
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('admin.students') }}" class="btn btn-outline-success w-100 py-3">
                                <i class="fas fa-users d-block mb-2"></i>
                                Danh sách SV
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('admin.enrollments') }}" class="btn btn-outline-info w-100 py-3">
                                <i class="fas fa-list-check d-block mb-2"></i>
                                Quản lý Đăng ký
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activities -->
    <div class="row">
        <!-- Recent Enrollments -->
        <div class="col-lg-6 mb-4">
            <div class="admin-card card h-100">
                <div class="card-header bg-white">
                    <h6 class="mb-0">
                        <i class="fas fa-clock me-2"></i>
                        Đăng ký gần đây
                    </h6>
                </div>
                <div class="card-body">
                    @if($recent_enrollments->count() > 0)
                        <div class="list-group list-group-flush">
                            @foreach($recent_enrollments as $enrollment)
                                <div class="list-group-item border-0 px-0">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <h6 class="mb-1">{{ $enrollment->student->name }}</h6>
                                            <p class="mb-1 text-muted small">
                                                {{ $enrollment->subject->subject_code }} - {{ $enrollment->subject->subject_name }}
                                            </p>
                                            <small class="text-muted">{{ $enrollment->created_at->diffForHumans() }}</small>
                                        </div>
                                        <span class="badge badge-status bg-{{ $enrollment->status_color }}">
                                            {{ $enrollment->status_text }}
                                        </span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center text-muted py-4">
                            <i class="fas fa-inbox fa-3x mb-3"></i>
                            <p>Chưa có đăng ký nào</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Recent Grades -->
        <div class="col-lg-6 mb-4">
            <div class="admin-card card h-100">
                <div class="card-header bg-white">
                    <h6 class="mb-0">
                        <i class="fas fa-star me-2"></i>
                        Điểm vừa chấm
                    </h6>
                </div>
                <div class="card-body">
                    @if($recent_grades->count() > 0)
                        <div class="list-group list-group-flush">
                            @foreach($recent_grades as $grade)
                                <div class="list-group-item border-0 px-0">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <h6 class="mb-1">{{ $grade->enrollment->student->name }}</h6>
                                            <p class="mb-1 text-muted small">
                                                {{ $grade->enrollment->subject->subject_code }} - {{ $grade->enrollment->subject->subject_name }}
                                            </p>
                                            <small class="text-muted">{{ $grade->created_at->diffForHumans() }}</small>
                                        </div>
                                        <div class="text-end">
                                            <span class="badge bg-{{ $grade->grade_color }} mb-1">
                                                {{ $grade->letter_grade }}
                                            </span>
                                            <br>
                                            <small class="text-muted">{{ $grade->total_score }}/10</small>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center text-muted py-4">
                            <i class="fas fa-chart-line fa-3x mb-3"></i>
                            <p>Chưa có điểm nào</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection