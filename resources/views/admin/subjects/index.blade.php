@extends('layouts.admin')

@section('title', 'Quản lý Môn học')
@section('page-title', 'Quản lý Môn học')

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
                                <i class="fas fa-book me-2 text-success"></i>
                                Danh sách Môn học
                            </h4>
                            <small class="text-muted">Tổng cộng: {{ $subjects->total() ?? 0 }} môn học</small>
                        </div>
                        <div class="col-md-6 text-end">
                            <a href="{{ route('admin.subjects.create') }}" class="btn btn-success">
                                <i class="fas fa-plus me-2"></i>
                                Thêm Môn học
                            </a>
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
                            <div class="text-xs fw-bold text-success text-uppercase mb-1">Tổng môn học</div>
                            <div class="h5 mb-0 fw-bold">{{ $subjects->total() ?? 0 }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-book fa-2x text-success"></i>
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
                            <div class="text-xs fw-bold text-primary text-uppercase mb-1">Đang hoạt động</div>
                            <div class="h5 mb-0 fw-bold">{{ $subjects->where('is_active', true)->count() ?? 0 }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-play fa-2x text-primary"></i>
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
                            <div class="text-xs fw-bold text-warning text-uppercase mb-1">Tạm dừng</div>
                            <div class="h5 mb-0 fw-bold">{{ $subjects->where('is_active', false)->count() ?? 0 }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-pause fa-2x text-warning"></i>
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
                            <div class="text-xs fw-bold text-info text-uppercase mb-1">Tổng tín chỉ</div>
                            <div class="h5 mb-0 fw-bold">{{ $subjects->sum('credits') ?? 0 }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calculator fa-2x text-info"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Search & Filter -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <form method="GET" action="{{ route('admin.subjects') }}">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-search"></i>
                                    </span>
                                    <input type="text" 
                                           class="form-control" 
                                           name="search" 
                                           placeholder="Tìm kiếm theo mã môn, tên môn học..."
                                           value="{{ request('search') }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <select class="form-select" name="credits">
                                    <option value="">Tất cả tín chỉ</option>
                                    <option value="1" {{ request('credits') == '1' ? 'selected' : '' }}>1 tín chỉ</option>
                                    <option value="2" {{ request('credits') == '2' ? 'selected' : '' }}>2 tín chỉ</option>
                                    <option value="3" {{ request('credits') == '3' ? 'selected' : '' }}>3 tín chỉ</option>
                                    <option value="4" {{ request('credits') == '4' ? 'selected' : '' }}>4 tín chỉ</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <button type="submit" class="btn btn-outline-primary me-2">
                                    <i class="fas fa-search me-1"></i>
                                    Tìm kiếm
                                </button>
                                <a href="{{ route('admin.subjects') }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-undo me-1"></i>
                                    Đặt lại
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Subjects Table -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom">
                    <h6 class="mb-0">Danh sách môn học</h6>
                </div>
                <div class="card-body p-0">
                    @if(isset($subjects) && $subjects->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th width="15%">Mã môn</th>
                                        <th width="30%">Tên môn học</th>
                                        <th width="10%">Tín chỉ</th>
                                        <th width="25%">Mô tả</th>
                                        <th width="10%">Trạng thái</th>
                                        <th width="10%" class="text-center">Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($subjects as $subject)
                                    <tr>
                                        <td>
                                            <span class="badge bg-primary fs-6">{{ $subject->subject_code }}</span>
                                        </td>
                                        <td>
                                            <div>
                                                <h6 class="mb-1">{{ $subject->subject_name }}</h6>
                                                <small class="text-muted">
                                                    <i class="fas fa-users me-1"></i>
                                                    {{ $subject->enrollments_count ?? 0 }} sinh viên đăng ký
                                                </small>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-info">{{ $subject->credits }}</span>
                                        </td>
                                        <td>
                                            <small class="text-muted">
                                                {{ Str::limit($subject->description, 50) ?? 'Chưa có mô tả' }}
                                            </small>
                                        </td>
                                        <td>
                                            @if($subject->is_active)
                                                <span class="badge bg-success">Hoạt động</span>
                                            @else
                                                <span class="badge bg-warning">Tạm dừng</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <div class="btn-group btn-group-sm">
                                                <a href="{{ route('admin.subjects.edit', $subject) }}" 
                                                   class="btn btn-outline-warning" title="Chỉnh sửa">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form method="POST" 
                                                      action="{{ route('admin.subjects.delete', $subject) }}" 
                                                      class="d-inline"
                                                      onsubmit="return confirm('Bạn có chắc muốn xóa môn học {{ $subject->subject_name }}?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-outline-danger" title="Xóa">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <!-- Pagination -->
                        @if(method_exists($subjects, 'links'))
                        <div class="card-footer bg-white">
                            {{ $subjects->links() }}
                        </div>
                        @endif
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-book fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">Không có môn học nào</h5>
                            <p class="text-muted">
                                @if(request('search'))
                                    Không tìm thấy kết quả cho "{{ request('search') }}"
                                @else
                                    Hãy thêm môn học đầu tiên
                                @endif
                            </p>
                            @if(!request('search'))
                            <a href="{{ route('admin.subjects.create') }}" class="btn btn-success">
                                <i class="fas fa-plus me-2"></i>
                                Thêm môn học đầu tiên
                            </a>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection