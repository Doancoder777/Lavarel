@extends('layouts.student')

@section('title', 'Đăng ký môn học')

@section('content')
<div class="welcome-header">
    <div class="row align-items-center">
        <div class="col-md-8">
            <h1 class="mb-2">
                <i class="fas fa-plus-circle"></i> Đăng ký môn học
            </h1>
            <p class="mb-0 opacity-90">
                Chọn môn học bạn muốn đăng ký trong học kỳ này
            </p>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('student.enrollments') }}" class="btn btn-light btn-lg">
                <i class="fas fa-list"></i> Môn đã đăng ký
            </a>
        </div>
    </div>
</div>

<!-- Available Subjects -->
<div class="card border-0 shadow-sm">
    <div class="card-header bg-light border-0">
        <div class="row align-items-center">
            <div class="col">
                <h5 class="mb-0">
                    <i class="fas fa-graduation-cap text-primary"></i> Môn học khả dụng
                </h5>
                <small class="text-muted">Các môn học bạn chưa đăng ký</small>
            </div>
            <div class="col-auto">
                <span class="badge bg-primary fs-6">{{ $availableSubjects->count() }} môn học</span>
            </div>
        </div>
    </div>
    <div class="card-body">
        @if($availableSubjects->count() > 0)
            <div class="row">
                @foreach($availableSubjects as $subject)
                <div class="col-lg-6 col-xl-4 mb-4">
                    <div class="card h-100 border-2">
                        <div class="card-header text-white" style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%);">
                            <div class="d-flex justify-content-between align-items-center">
                                <h6 class="mb-0 fw-bold">{{ $subject->subject_code }}</h6>
                                <span class="badge bg-light text-dark">{{ $subject->credits }} TC</span>
                            </div>
                        </div>
                        <div class="card-body d-flex flex-column">
                            <h6 class="card-title text-primary mb-2">{{ $subject->subject_name }}</h6>
                            <p class="card-text text-muted flex-grow-1">
                                {{ $subject->description ?: 'Mô tả môn học sẽ được cập nhật sau.' }}
                            </p>
                            
                            <div class="mt-auto">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <small class="text-muted">
                                        <i class="fas fa-graduation-cap"></i> {{ $subject->credits }} tín chỉ
                                    </small>
                                    <small class="text-muted">
                                        <i class="fas fa-clock"></i> Học kỳ hiện tại
                                    </small>
                                </div>
                                
                                <!-- SIMPLE FORM - NO JAVASCRIPT -->
                                <form method="POST" action="{{ route('student.enroll.process') }}" style="display: inline;">
                                    @csrf
                                    <input type="hidden" name="subject_id" value="{{ $subject->id }}">
                                    <button type="submit" class="btn btn-success w-100">
                                        <i class="fas fa-plus"></i> Đăng ký môn này
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-check-circle fa-4x text-success mb-3"></i>
                <h5 class="text-success">Tuyệt vời!</h5>
                <p class="text-muted mb-4">Bạn đã đăng ký tất cả các môn học có sẵn.</p>
                <a href="{{ route('student.enrollments') }}" class="btn btn-primary">
                    <i class="fas fa-eye"></i> Xem môn đã đăng ký
                </a>
            </div>
        @endif
    </div>
</div>

<!-- Information Section -->
<div class="card border-0 shadow-sm mt-4">
    <div class="card-header bg-light border-0">
        <h5 class="mb-0">
            <i class="fas fa-info-circle text-info"></i> Thông tin đăng ký
        </h5>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <h6 class="text-primary">Quy định đăng ký:</h6>
                <ul class="list-unstyled">
                    <li><i class="fas fa-check text-success"></i> Tối đa 20 tín chỉ/học kỳ</li>
                    <li><i class="fas fa-check text-success"></i> Tối thiểu 12 tín chỉ/học kỳ</li>
                    <li><i class="fas fa-check text-success"></i> Có thể hủy trong 2 tuần đầu</li>
                    <li><i class="fas fa-check text-success"></i> Đăng ký theo thứ tự ưu tiên</li>
                </ul>
            </div>
            <div class="col-md-6">
                <h6 class="text-primary">Lưu ý quan trọng:</h6>
                <ul class="list-unstyled">
                    <li><i class="fas fa-exclamation-triangle text-warning"></i> Kiểm tra điều kiện tiên quyết</li>
                    <li><i class="fas fa-exclamation-triangle text-warning"></i> Xem kỹ lịch học trước khi đăng ký</li>
                    <li><i class="fas fa-exclamation-triangle text-warning"></i> Đóng học phí đúng hạn</li>
                    <li><i class="fas fa-exclamation-triangle text-warning"></i> Liên hệ phòng đào tạo nếu có vấn đề</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection