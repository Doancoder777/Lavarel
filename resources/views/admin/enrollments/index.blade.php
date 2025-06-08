@extends('layouts.admin')

@section('title', 'Quản lý Đăng ký')
@section('page-title', 'Quản lý Đăng ký')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <h4 class="mb-0">
                                <i class="fas fa-clipboard-list me-2 text-info"></i>
                                Quản lý Đăng ký môn học
                            </h4>
                            <small class="text-muted">Tổng cộng: {{ $enrollments->total() ?? 0 }} đăng ký</small>
                        </div>
                        <div class="col-md-6 text-end">
                            <div class="text-muted">
                                <small>
                                    <i class="fas fa-info-circle me-1"></i>
                                    Click vào biểu tượng để thay đổi trạng thái đăng ký
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <div class="text-xs fw-bold text-primary text-uppercase mb-1">Tổng đăng ký</div>
                            <div class="h5 mb-0 fw-bold">{{ $enrollments->total() ?? 0 }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clipboard-list fa-2x text-primary"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <div class="text-xs fw-bold text-success text-uppercase mb-1">Đang học</div>
                            <div class="h5 mb-0 fw-bold">{{ $enrollments->where('status', 'enrolled')->count() ?? 0 }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-play fa-2x text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <div class="text-xs fw-bold text-info text-uppercase mb-1">Hoàn thành</div>
                            <div class="h5 mb-0 fw-bold">{{ $enrollments->where('status', 'completed')->count() ?? 0 }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check fa-2x text-info"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <div class="text-xs fw-bold text-warning text-uppercase mb-1">Đã bỏ</div>
                            <div class="h5 mb-0 fw-bold">{{ $enrollments->where('status', 'dropped')->count() ?? 0 }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-times fa-2x text-warning"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <form method="GET" action="{{ route('admin.enrollments') }}">
                        <div class="row">
                            <div class="col-md-3">
                                <label for="status" class="form-label">Trạng thái</label>
                                <select class="form-select" name="status" id="status">
                                    <option value="">Tất cả trạng thái</option>
                                    <option value="enrolled" {{ request('status') == 'enrolled' ? 'selected' : '' }}>Đang học</option>
                                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Hoàn thành</option>
                                    <option value="dropped" {{ request('status') == 'dropped' ? 'selected' : '' }}>Đã bỏ</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="semester" class="form-label">Học kỳ</label>
                                <select class="form-select" name="semester" id="semester">
                                    <option value="">Tất cả học kỳ</option>
                                    @if(isset($semesters))
                                        @foreach($semesters as $semester)
                                            <option value="{{ $semester }}" {{ request('semester') == $semester ? 'selected' : '' }}>
                                                {{ $semester }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="search" class="form-label">Tìm kiếm</label>
                                <input type="text" class="form-control" name="search" id="search" 
                                       placeholder="Tên sinh viên, môn học..." value="{{ request('search') }}">
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">&nbsp;</label>
                                <div class="d-grid gap-2">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-search"></i> Lọc
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Enrollments Table -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom">
                    <h6 class="mb-0">Danh sách đăng ký</h6>
                </div>
                <div class="card-body p-0">
                    @if(isset($enrollments) && $enrollments->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th width="18%">Sinh viên</th>
                                        <th width="22%">Môn học</th>
                                        <th width="10%">Học kỳ</th>
                                        <th width="12%">Ngày đăng ký</th>
                                        <th width="10%">Trạng thái</th>
                                        <th width="10%">Điểm</th>
                                        <th width="18%" class="text-center">Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($enrollments as $enrollment)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-sm bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2">
                                                    {{ strtoupper(substr($enrollment->student->name, 0, 1)) }}
                                                </div>
                                                <div>
                                                    <h6 class="mb-0">{{ $enrollment->student->name }}</h6>
                                                    <small class="text-muted">{{ $enrollment->student->student_id }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div>
                                                <span class="badge bg-secondary mb-1">{{ $enrollment->subject->subject_code }}</span>
                                                <br>
                                                <span class="fw-medium">{{ $enrollment->subject->subject_name }}</span>
                                                <br>
                                                <small class="text-muted">{{ $enrollment->subject->credits }} tín chỉ</small>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-info">{{ $enrollment->semester }}</span>
                                        </td>
                                        <td>
                                            <small>{{ $enrollment->enrollment_date->format('d/m/Y') }}</small>
                                        </td>
                                        <td>
                                            @if($enrollment->status == 'enrolled')
                                                <span class="badge bg-success">Đang học</span>
                                            @elseif($enrollment->status == 'completed')
                                                <span class="badge bg-primary">Hoàn thành</span>
                                            @elseif($enrollment->status == 'dropped')
                                                <span class="badge bg-warning">Đã bỏ</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($enrollment->grade)
                                                <div class="text-center">
                                                    <span class="badge bg-{{ $enrollment->grade->grade_color }}">
                                                        {{ $enrollment->grade->letter_grade }}
                                                    </span>
                                                    <br>
                                                    <small class="text-muted">{{ $enrollment->grade->total_score }}/10</small>
                                                </div>
                                            @else
                                                <span class="text-muted">Chưa có</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <div class="btn-group btn-group-sm">
                                                <!-- Đánh dấu hoàn thành -->
                                                @if($enrollment->status == 'enrolled')
                                                <form method="POST" action="{{ route('admin.enrollments.status', $enrollment) }}" class="d-inline">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="status" value="completed">
                                                    <button type="submit" class="btn btn-success btn-sm" 
                                                            title="Đánh dấu hoàn thành"
                                                            onclick="return confirm('Đánh dấu môn học này đã hoàn thành?')">
                                                        <i class="fas fa-check"></i>
                                                    </button>
                                                </form>
                                                @endif
                                                
                                                <!-- Đánh dấu đã bỏ -->
                                                @if($enrollment->status == 'enrolled')
                                                <form method="POST" action="{{ route('admin.enrollments.status', $enrollment) }}" class="d-inline">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="status" value="dropped">
                                                    <button type="submit" class="btn btn-warning btn-sm" 
                                                            title="Đánh dấu đã bỏ học"
                                                            onclick="return confirm('Bạn có chắc muốn đánh dấu sinh viên này đã bỏ môn?')">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </form>
                                                @endif
                                                
                                                <!-- Khôi phục trạng thái enrolled -->
                                                @if($enrollment->status == 'completed' || $enrollment->status == 'dropped')
                                                <form method="POST" action="{{ route('admin.enrollments.status', $enrollment) }}" class="d-inline">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="status" value="enrolled">
                                                    <button type="submit" class="btn btn-outline-primary btn-sm" 
                                                            title="Khôi phục trạng thái đang học"
                                                            onclick="return confirm('Khôi phục trạng thái đang học cho sinh viên này?')">
                                                        <i class="fas fa-undo"></i>
                                                    </button>
                                                </form>
                                                @endif
                                                
                                                <!-- Hiển thị thông báo nếu không có action -->
                                                @if($enrollment->status == 'completed')
                                                    <small class="text-success">
                                                        <i class="fas fa-check-circle"></i> Đã hoàn thành
                                                    </small>
                                                @elseif($enrollment->status == 'dropped')
                                                    <small class="text-warning">
                                                        <i class="fas fa-ban"></i> Đã bỏ học
                                                    </small>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <!-- Pagination -->
                        @if(method_exists($enrollments, 'links'))
                        <div class="card-footer bg-white">
                            {{ $enrollments->links() }}
                        </div>
                        @endif
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-clipboard-list fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">Không có đăng ký nào</h5>
                            <p class="text-muted">
                                @if(request('status') || request('semester') || request('search'))
                                    Không tìm thấy kết quả phù hợp với bộ lọc
                                @else
                                    Chưa có sinh viên nào đăng ký môn học
                                @endif
                            </p>
                            @if(request()->hasAny(['status', 'semester', 'search']))
                            <a href="{{ route('admin.enrollments') }}" class="btn btn-outline-primary">
                                <i class="fas fa-undo me-2"></i>
                                Xóa bộ lọc
                            </a>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.avatar-sm {
    width: 35px;
    height: 35px;
    font-size: 14px;
}

.btn-group-sm .btn {
    margin: 1px;
}
</style>
@endsection