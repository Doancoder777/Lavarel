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

<!-- Available Subjects - COLORFUL CARDS -->
<div class="card border-0 shadow-lg modern-card">
    <div class="card-header bg-gradient-header border-0">
        <div class="row align-items-center">
            <div class="col">
                <h5 class="mb-0 text-white">
                    <i class="fas fa-graduation-cap me-2"></i> Môn học khả dụng
                </h5>
                <small class="text-white-50">Các môn học bạn chưa đăng ký</small>
            </div>
            <div class="col-auto">
                <span class="badge bg-light text-dark fs-6 px-3 py-2">{{ $availableSubjects->count() }} môn học</span>
            </div>
        </div>
    </div>
    <div class="card-body p-4">
        @if($availableSubjects->count() > 0)
            <div class="row">
                @foreach($availableSubjects as $index => $subject)
                <div class="col-lg-6 col-xl-4 mb-4">
                    <div class="subject-card h-100 subject-card-{{ $index % 6 }}" data-index="{{ $index }}">
                        <div class="card-header-colorful card-header-{{ $index % 6 }}">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-code me-2"></i>
                                    <h6 class="mb-0 fw-bold">{{ $subject->subject_code }}</h6>
                                </div>
                                <span class="badge bg-white text-dark px-3 py-1">{{ $subject->credits }} TC</span>
                            </div>
                            <div class="decorative-circle"></div>
                            <div class="decorative-circle-2"></div>
                        </div>
                        
                        <div class="card-body-colorful d-flex flex-column">
                            <h6 class="card-title-colorful mb-3">{{ $subject->subject_name }}</h6>
                            <p class="card-text text-muted flex-grow-1 mb-4">
                                {{ $subject->description ?: 'Mô tả môn học sẽ được cập nhật sau.' }}
                            </p>
                            
                            <div class="mt-auto">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <small class="text-muted d-flex align-items-center">
                                        <i class="fas fa-graduation-cap me-1"></i> {{ $subject->credits }} tín chỉ
                                    </small>
                                    <small class="text-muted d-flex align-items-center">
                                        <i class="fas fa-clock me-1"></i> Học kỳ hiện tại
                                    </small>
                                </div>
                                
                                <!-- COLORFUL FORM -->
                                <form method="POST" action="{{ route('student.enroll.process') }}" style="display: inline;">
                                    @csrf
                                    <input type="hidden" name="subject_id" value="{{ $subject->id }}">
                                    <button type="submit" class="btn btn-enroll-{{ $index % 6 }} w-100 fw-bold">
                                        <i class="fas fa-plus me-2"></i> Đăng ký môn này
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
                <div class="empty-state-icon mb-4">
                    <i class="fas fa-check-circle"></i>
                </div>
                <h5 class="text-success mb-3">Tuyệt vời!</h5>
                <p class="text-muted mb-4">Bạn đã đăng ký tất cả các môn học có sẵn.</p>
                <a href="{{ route('student.enrollments') }}" class="btn btn-gradient-primary">
                    <i class="fas fa-eye me-2"></i> Xem môn đã đăng ký
                </a>
            </div>
        @endif
    </div>
</div>

<!-- Information Section - COLORFUL -->
<div class="card border-0 shadow-lg modern-card mt-4">
    <div class="card-header bg-gradient-info border-0">
        <h5 class="mb-0 text-white">
            <i class="fas fa-info-circle me-2"></i> Thông tin đăng ký
        </h5>
    </div>
    <div class="card-body p-4">
        <div class="row">
            <div class="col-md-6 mb-4">
                <div class="info-section rules-section">
                    <h6 class="section-title">
                        <i class="fas fa-clipboard-check me-2"></i>
                        Quy định đăng ký:
                    </h6>
                    <ul class="info-list">
                        <li><i class="fas fa-check"></i> Tối đa 20 tín chỉ/học kỳ</li>
                        <li><i class="fas fa-check"></i> Tối thiểu 12 tín chỉ/học kỳ</li>
                        <li><i class="fas fa-check"></i> Có thể hủy trong 2 tuần đầu</li>
                        <li><i class="fas fa-check"></i> Đăng ký theo thứ tự ưu tiên</li>
                    </ul>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="info-section notes-section">
                    <h6 class="section-title">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        Lưu ý quan trọng:
                    </h6>
                    <ul class="info-list">
                        <li><i class="fas fa-eye"></i> Kiểm tra điều kiện tiên quyết</li>
                        <li><i class="fas fa-calendar"></i> Xem kỹ lịch học trước khi đăng ký</li>
                        <li><i class="fas fa-credit-card"></i> Đóng học phí đúng hạn</li>
                        <li><i class="fas fa-phone"></i> Liên hệ phòng đào tạo nếu có vấn đề</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* FIXED COLORFUL ENROLLMENT PAGE - NO CSS ERRORS */

/* Modern Cards */
.modern-card {
    border-radius: 20px;
    overflow: hidden;
    transition: all 0.3s ease;
}

.modern-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 35px rgba(0,0,0,0.1) !important;
}

/* Gradient Headers */
.bg-gradient-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.bg-gradient-info {
    background: linear-gradient(135deg, #17a2b8 0%, #138496 100%);
}

/* Subject Cards */
.subject-card {
    border: none;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 8px 25px rgba(0,0,0,0.1);
    transition: all 0.4s ease;
    position: relative;
}

.subject-card:hover {
    transform: translateY(-10px) scale(1.02);
    box-shadow: 0 20px 40px rgba(0,0,0,0.15);
}

/* Card Headers - 6 Different Colors */
.card-header-0 { background: linear-gradient(135deg, #667eea, #764ba2); }
.card-header-1 { background: linear-gradient(135deg, #f093fb, #f5576c); }
.card-header-2 { background: linear-gradient(135deg, #4facfe, #00f2fe); }
.card-header-3 { background: linear-gradient(135deg, #43e97b, #38f9d7); }
.card-header-4 { background: linear-gradient(135deg, #fa709a, #fee140); }
.card-header-5 { background: linear-gradient(135deg, #a8edea, #fed6e3); }

.card-header-colorful {
    padding: 1.5rem;
    color: white;
    position: relative;
    overflow: hidden;
}

.decorative-circle {
    position: absolute;
    top: -20px;
    right: -20px;
    width: 80px;
    height: 80px;
    background: rgba(255,255,255,0.1);
    border-radius: 50%;
}

.decorative-circle-2 {
    position: absolute;
    bottom: -30px;
    left: -30px;
    width: 100px;
    height: 100px;
    background: rgba(255,255,255,0.05);
    border-radius: 50%;
}

.card-body-colorful {
    padding: 1.5rem;
    background: white;
}

.card-title-colorful {
    font-weight: 600;
    color: #2c3e50;
    font-size: 1.1rem;
    line-height: 1.3;
}

/* Enrollment Buttons - 6 Different Colors */
.btn-enroll-0 {
    background: linear-gradient(135deg, #667eea, #764ba2);
    border: none;
    color: white;
    border-radius: 12px;
    padding: 0.75rem 1rem;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
}

.btn-enroll-0:hover {
    background: linear-gradient(135deg, #5a67d8, #6b46c1);
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
    color: white;
}

.btn-enroll-1 {
    background: linear-gradient(135deg, #f093fb, #f5576c);
    border: none;
    color: white;
    border-radius: 12px;
    padding: 0.75rem 1rem;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(240, 147, 251, 0.3);
}

.btn-enroll-1:hover {
    background: linear-gradient(135deg, #ec4899, #ef4444);
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(240, 147, 251, 0.4);
    color: white;
}

.btn-enroll-2 {
    background: linear-gradient(135deg, #4facfe, #00f2fe);
    border: none;
    color: white;
    border-radius: 12px;
    padding: 0.75rem 1rem;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(79, 172, 254, 0.3);
}

.btn-enroll-2:hover {
    background: linear-gradient(135deg, #3b82f6, #06b6d4);
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(79, 172, 254, 0.4);
    color: white;
}

.btn-enroll-3 {
    background: linear-gradient(135deg, #43e97b, #38f9d7);
    border: none;
    color: white;
    border-radius: 12px;
    padding: 0.75rem 1rem;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(67, 233, 123, 0.3);
}

.btn-enroll-3:hover {
    background: linear-gradient(135deg, #10b981, #14b8a6);
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(67, 233, 123, 0.4);
    color: white;
}

.btn-enroll-4 {
    background: linear-gradient(135deg, #fa709a, #fee140);
    border: none;
    color: white;
    border-radius: 12px;
    padding: 0.75rem 1rem;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(250, 112, 154, 0.3);
}

.btn-enroll-4:hover {
    background: linear-gradient(135deg, #f59e0b, #eab308);
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(250, 112, 154, 0.4);
    color: white;
}

.btn-enroll-5 {
    background: linear-gradient(135deg, #a8edea, #fed6e3);
    border: none;
    color: #2c3e50;
    border-radius: 12px;
    padding: 0.75rem 1rem;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(168, 237, 234, 0.3);
}

.btn-enroll-5:hover {
    background: linear-gradient(135deg, #67e8f9, #fbbf24);
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(168, 237, 234, 0.4);
    color: #2c3e50;
}

.btn-gradient-primary {
    background: linear-gradient(135deg, #667eea, #764ba2);
    border: none;
    color: white;
    border-radius: 12px;
    padding: 0.75rem 2rem;
    font-weight: 600;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
}

.btn-gradient-primary:hover {
    background: linear-gradient(135deg, #5a67d8, #6b46c1);
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
    color: white;
}

/* Empty State */
.empty-state-icon {
    width: 100px;
    height: 100px;
    margin: 0 auto;
    background: linear-gradient(135deg, #10b981, #14b8a6);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 10px 30px rgba(16, 185, 129, 0.3);
}

.empty-state-icon i {
    font-size: 3rem;
    color: white;
}

/* Information Sections */
.info-section {
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.05), rgba(118, 75, 162, 0.05));
    border-radius: 15px;
    padding: 1.5rem;
    height: 100%;
    border-left: 4px solid transparent;
    transition: all 0.3s ease;
}

.rules-section {
    border-left-color: #10b981;
}

.notes-section {
    border-left-color: #f59e0b;
}

.info-section:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.1);
}

.section-title {
    color: #2c3e50;
    font-weight: 600;
    margin-bottom: 1rem;
    display: flex;
    align-items: center;
}

.rules-section .section-title i {
    color: #10b981;
}

.notes-section .section-title i {
    color: #f59e0b;
}

.info-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.info-list li {
    display: flex;
    align-items: center;
    padding: 0.5rem 0;
    color: #495057;
    transition: all 0.3s ease;
}

.info-list li:hover {
    transform: translateX(5px);
    color: #2c3e50;
}

.info-list li i {
    width: 20px;
    margin-right: 0.75rem;
    font-size: 0.9rem;
}

.rules-section .info-list li i {
    color: #10b981;
}

.notes-section .info-list li i {
    color: #f59e0b;
}

/* Card Entrance Animation */
.subject-card {
    animation: slideInUp 0.6s ease forwards;
    opacity: 0;
    transform: translateY(30px);
}

.subject-card[data-index="0"] { animation-delay: 0.1s; }
.subject-card[data-index="1"] { animation-delay: 0.2s; }
.subject-card[data-index="2"] { animation-delay: 0.3s; }
.subject-card[data-index="3"] { animation-delay: 0.4s; }
.subject-card[data-index="4"] { animation-delay: 0.5s; }
.subject-card[data-index="5"] { animation-delay: 0.6s; }

@keyframes slideInUp {
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Responsive */
@media (max-width: 768px) {
    .subject-card {
        margin-bottom: 1.5rem;
    }
    
    .card-header-colorful {
        padding: 1rem;
    }
    
    .card-body-colorful {
        padding: 1rem;
    }
    
    .info-section {
        margin-bottom: 1rem;
    }
}
</style>
@endsection