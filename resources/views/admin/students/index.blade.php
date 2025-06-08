@extends('layouts.admin')

@section('title', 'Quản lý Sinh viên')
@section('page-title', 'Quản lý Sinh viên')

@section('content')
<div class="container-fluid">
    <!-- Header Actions -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <h4 class="mb-0">
                                <i class="fas fa-user-graduate me-2 text-primary"></i>
                                Danh sách Sinh viên
                            </h4>
                            <small class="text-muted">Tổng cộng: {{ $students->total() ?? 0 }} sinh viên</small>
                        </div>
                        <div class="col-md-6 text-end">
                            <a href="{{ route('admin.students.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus me-2"></i>
                                Thêm Sinh viên
                            </a>
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
                    <form method="GET" action="{{ route('admin.students') }}">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-search"></i>
                                    </span>
                                    <input type="text" 
                                           class="form-control" 
                                           name="search" 
                                           placeholder="Tìm kiếm theo tên, email, mã sinh viên..."
                                           value="{{ request('search') }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <button type="submit" class="btn btn-outline-primary me-2">
                                    <i class="fas fa-search me-1"></i>
                                    Tìm kiếm
                                </button>
                                <a href="{{ route('admin.students') }}" class="btn btn-outline-secondary">
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

    <!-- Students Table -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom">
                    <div class="row align-items-center">
                        <div class="col">
                            <h6 class="mb-0">Danh sách sinh viên</h6>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    @if(isset($students) && $students->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th width="10%">Mã SV</th>
                                        <th width="25%">Họ tên</th>
                                        <th width="25%">Email</th>
                                        <th width="15%">Điện thoại</th>
                                        <th width="10%">Đăng ký</th>
                                        <th width="15%" class="text-center">Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($students as $student)
                                    <tr>
                                        <td>
                                            <span class="badge bg-primary">{{ $student->student_id }}</span>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-sm bg-light rounded-circle d-flex align-items-center justify-content-center me-2">
                                                    <i class="fas fa-user text-muted"></i>
                                                </div>
                                                <div>
                                                    <h6 class="mb-0">{{ $student->name }}</h6>
                                                    <small class="text-muted">{{ $student->address ?? 'Chưa cập nhật' }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ $student->email }}</td>
                                        <td>{{ $student->phone ?? 'Chưa có' }}</td>
                                        <td>
                                            <span class="badge bg-info">{{ $student->enrollments_count ?? 0 }}</span>
                                        </td>
                                        <td class="text-center">
                                            <div class="btn-group btn-group-sm">
                                                <a href="{{ route('admin.students.edit', $student) }}" 
                                                   class="btn btn-outline-warning" title="Chỉnh sửa">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form method="POST" 
                                                      action="{{ route('admin.students.delete', $student) }}" 
                                                      class="d-inline"
                                                      onsubmit="return confirm('Bạn có chắc muốn xóa sinh viên {{ $student->name }}?')">
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
                        @if(method_exists($students, 'links'))
                        <div class="card-footer bg-white">
                            {{ $students->links() }}
                        </div>
                        @endif
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-user-graduate fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">Không có sinh viên nào</h5>
                            <p class="text-muted">
                                @if(request('search'))
                                    Không tìm thấy kết quả cho "{{ request('search') }}"
                                @else
                                    Hãy thêm sinh viên đầu tiên
                                @endif
                            </p>
                            @if(!request('search'))
                            <a href="{{ route('admin.students.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus me-2"></i>
                                Thêm Sinh viên đầu tiên
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
}
</style>
@endsection