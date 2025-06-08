@extends('layouts.student')

@section('title', 'Hồ sơ cá nhân')

@section('content')
<div class="welcome-header">
    <div class="row align-items-center">
        <div class="col-md-8">
            <h1 class="mb-2">
                <i class="fas fa-user-edit"></i> Hồ sơ cá nhân
            </h1>
            <p class="mb-0 opacity-90">
                Quản lý thông tin cá nhân và thay đổi mật khẩu
            </p>
        </div>
        <div class="col-md-4 text-end">
            <div class="profile-avatar-header">
                <div class="avatar-circle-header">
                    {{ substr($student->name, 0, 1) }}
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Profile Form -->
    <div class="col-lg-8 mb-4">
        <div class="card border-0 shadow-lg modern-card">
            <div class="card-header bg-gradient-primary border-0">
                <h5 class="mb-0 text-white">
                    <i class="fas fa-edit me-2"></i> Cập nhật thông tin
                </h5>
            </div>
            <div class="card-body p-4">
                <form method="POST" action="{{ route('student.profile.update') }}">
                    @csrf
                    
                    <!-- Personal Information -->
                    <div class="info-section mb-4">
                        <h6 class="section-title">
                            <i class="fas fa-user me-2"></i>
                            Thông tin cá nhân
                        </h6>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Họ và tên</label>
                                <input type="text" name="name" class="form-control modern-input @error('name') is-invalid @enderror" 
                                       value="{{ old('name', $student->name) }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Mã sinh viên</label>
                                <input type="text" class="form-control modern-input" 
                                       value="{{ $student->student_id }}" readonly>
                                <small class="text-muted">Mã sinh viên không thể thay đổi</small>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Email</label>
                                <input type="email" class="form-control modern-input" 
                                       value="{{ $student->email }}" readonly>
                                <small class="text-muted">Email không thể thay đổi</small>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Số điện thoại</label>
                                <input type="text" name="phone" class="form-control modern-input @error('phone') is-invalid @enderror" 
                                       value="{{ old('phone', $student->phone) }}" placeholder="Nhập số điện thoại">
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold">Địa chỉ</label>
                            <textarea name="address" class="form-control modern-input @error('address') is-invalid @enderror" 
                                      rows="3" placeholder="Nhập địa chỉ">{{ old('address', $student->address) }}</textarea>
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Password Change -->
                    <div class="info-section mb-4">
                        <h6 class="section-title">
                            <i class="fas fa-lock me-2"></i>
                            Thay đổi mật khẩu
                        </h6>
                        <small class="text-muted mb-3 d-block">Để trống nếu không muốn thay đổi mật khẩu</small>
                        
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-bold">Mật khẩu hiện tại</label>
                                <input type="password" name="current_password" class="form-control modern-input @error('current_password') is-invalid @enderror" 
                                       placeholder="Nhập mật khẩu hiện tại">
                                @error('current_password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-bold">Mật khẩu mới</label>
                                <input type="password" name="new_password" class="form-control modern-input @error('new_password') is-invalid @enderror" 
                                       placeholder="Nhập mật khẩu mới">
                                @error('new_password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-bold">Xác nhận mật khẩu</label>
                                <input type="password" name="new_password_confirmation" class="form-control modern-input" 
                                       placeholder="Xác nhận mật khẩu mới">
                            </div>
                        </div>
                    </div>

                    <!-- Submit Buttons -->
                    <div class="d-flex gap-3">
                        <button type="submit" class="btn btn-gradient-primary px-4">
                            <i class="fas fa-save me-2"></i> Cập nhật thông tin
                        </button>
                        <a href="{{ route('student.dashboard') }}" class="btn btn-outline-secondary px-4">
                            <i class="fas fa-arrow-left me-2"></i> Quay lại
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Profile Summary -->
    <div class="col-lg-4 mb-4">
        <!-- Avatar & Info -->
        <div class="card border-0 shadow-lg modern-card mb-4">
            <div class="card-header bg-gradient-info border-0">
                <h5 class="mb-0 text-white">
                    <i class="fas fa-id-card me-2"></i> Thông tin sinh viên
                </h5>
            </div>
            <div class="card-body text-center p-4">
                <div class="profile-avatar-large mb-3">
                    <div class="avatar-wrapper">
                        <span>{{ substr($student->name, 0, 1) }}</span>
                        <div class="avatar-ring"></div>
                    </div>
                    <div class="online-indicator-large"></div>
                </div>
                
                <h4 class="profile-name">{{ $student->name }}</h4>
                <p class="profile-id text-muted">{{ $student->student_id }}</p>
                <p class="profile-join-date">
                    <i class="fas fa-calendar-alt me-1"></i>
                    Tham gia {{ $student->created_at->format('d/m/Y') }}
                </p>

                <div class="profile-details text-start mt-3">
                    <div class="detail-item">
                        <i class="fas fa-envelope text-primary"></i>
                        <span>{{ $student->email }}</span>
                    </div>
                    
                    @if($student->phone)
                    <div class="detail-item">
                        <i class="fas fa-phone text-success"></i>
                        <span>{{ $student->phone }}</span>
                    </div>
                    @endif
                    
                    @if($student->address)
                    <div class="detail-item">
                        <i class="fas fa-map-marker-alt text-warning"></i>
                        <span>{{ $student->address }}</span>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Academic Stats -->
        <div class="card border-0 shadow-lg modern-card">
            <div class="card-header bg-gradient-success border-0">
                <h5 class="mb-0 text-white">
                    <i class="fas fa-chart-line me-2"></i> Thống kê học tập
                </h5>
            </div>
            <div class="card-body p-4">
                <div class="stats-grid">
                    <div class="stat-item">
                        <div class="stat-icon bg-primary">
                            <i class="fas fa-book"></i>
                        </div>
                        <div class="stat-content">
                            <div class="stat-number">{{ $stats['total_enrollments'] }}</div>
                            <div class="stat-label">Tổng môn học</div>
                        </div>
                    </div>
                    
                    <div class="stat-item">
                        <div class="stat-icon bg-success">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="stat-content">
                            <div class="stat-number">{{ $stats['completed_subjects'] }}</div>
                            <div class="stat-label">Hoàn thành</div>
                        </div>
                    </div>
                    
                    <div class="stat-item">
                        <div class="stat-icon bg-warning">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="stat-content">
                            <div class="stat-number">{{ $stats['active_enrollments'] }}</div>
                            <div class="stat-label">Đang học</div>
                        </div>
                    </div>
                    
                    <div class="stat-item">
                        <div class="stat-icon bg-info">
                            <i class="fas fa-star"></i>
                        </div>
                        <div class="stat-content">
                            <div class="stat-number">{{ number_format($stats['gpa'], 2) }}</div>
                            <div class="stat-label">GPA</div>
                        </div>
                    </div>
                </div>

                <div class="mt-4">
                    <h6 class="mb-3">Thành tích gần đây:</h6>
                    @if($recentGrades->count() > 0)
                        <div class="recent-grades">
                            @foreach($recentGrades->take(3) as $grade)
                            <div class="grade-item">
                                <div class="grade-subject">{{ $grade->enrollment->subject->subject_code }}</div>
                                <div class="grade-score badge bg-{{ $grade->letter_grade == 'A' ? 'success' : ($grade->letter_grade == 'B' ? 'primary' : 'warning') }}">
                                    {{ $grade->letter_grade }}
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted">Chưa có điểm số nào</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* PROFILE PAGE STYLES */

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
.bg-gradient-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.bg-gradient-info {
    background: linear-gradient(135deg, #17a2b8 0%, #138496 100%);
}

.bg-gradient-success {
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
}

/* Header Avatar */
.profile-avatar-header {
    display: flex;
    justify-content: center;
    align-items: center;
}

.avatar-circle-header {
    width: 80px;
    height: 80px;
    background: linear-gradient(135deg, rgba(255,255,255,0.2), rgba(255,255,255,0.1));
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: 700;
    font-size: 2rem;
    border: 3px solid rgba(255,255,255,0.3);
    box-shadow: 0 8px 25px rgba(255,255,255,0.2);
}

/* Form Styles */
.modern-input {
    border: 2px solid #e9ecef;
    border-radius: 12px;
    padding: 0.75rem 1rem;
    transition: all 0.3s ease;
    background: #f8f9fa;
}

.modern-input:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 0.25rem rgba(102, 126, 234, 0.15);
    background: white;
}

.modern-input:read-only {
    background: #e9ecef;
    border-color: #dee2e6;
    color: #6c757d;
}

/* Information Sections */
.info-section {
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.03), rgba(118, 75, 162, 0.03));
    border-radius: 15px;
    padding: 1.5rem;
    border-left: 4px solid #667eea;
    margin-bottom: 1.5rem;
}

.section-title {
    color: #2c3e50;
    font-weight: 600;
    margin-bottom: 1rem;
    display: flex;
    align-items: center;
    font-size: 1.1rem;
}

.section-title i {
    color: #667eea;
}

/* Profile Avatar Large */
.profile-avatar-large {
    position: relative;
    display: inline-block;
}

.avatar-wrapper {
    width: 100px;
    height: 100px;
    background: linear-gradient(135deg, #17a2b8 0%, #138496 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 2.5rem;
    font-weight: 700;
    position: relative;
    box-shadow: 0 10px 30px rgba(23, 162, 184, 0.3);
}

.avatar-ring {
    position: absolute;
    top: -5px;
    left: -5px;
    right: -5px;
    bottom: -5px;
    border-radius: 50%;
    border: 3px solid transparent;
    background: linear-gradient(45deg, #17a2b8, #138496, #20c997) border-box;
    mask: linear-gradient(#fff 0 0) padding-box, linear-gradient(#fff 0 0);
    mask-composite: subtract;
    animation: rotate 6s linear infinite;
}

.online-indicator-large {
    position: absolute;
    bottom: 8px;
    right: 8px;
    width: 24px;
    height: 24px;
    background: #28a745;
    border-radius: 50%;
    border: 4px solid white;
    box-shadow: 0 0 15px rgba(40, 167, 69, 0.5);
    animation: pulse-green 2s infinite;
}

@keyframes rotate {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

@keyframes pulse-green {
    0% { box-shadow: 0 0 0 0 rgba(40, 167, 69, 0.7); }
    70% { box-shadow: 0 0 0 10px rgba(40, 167, 69, 0); }
    100% { box-shadow: 0 0 0 0 rgba(40, 167, 69, 0); }
}

/* Profile Info */
.profile-name {
    font-size: 1.5rem;
    font-weight: 600;
    color: #2c3e50;
    margin-bottom: 0.5rem;
}

.profile-id {
    font-weight: 500;
    font-size: 1.1rem;
}

.profile-join-date {
    color: #6c757d;
    font-size: 0.9rem;
    margin-bottom: 1rem;
}

.detail-item {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.75rem 0;
    border-bottom: 1px solid #e9ecef;
    color: #495057;
}

.detail-item:last-child {
    border-bottom: none;
}

.detail-item i {
    width: 16px;
    text-align: center;
}

/* Stats Grid */
.stats-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1rem;
    margin-bottom: 1rem;
}

.stat-item {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 1rem;
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
}

.stat-item:hover {
    transform: translateY(-3px);
    box-shadow: 0 4px 15px rgba(0,0,0,0.15);
}

.stat-icon {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.2rem;
}

.stat-content {
    flex: 1;
}

.stat-number {
    font-size: 1.25rem;
    font-weight: 700;
    color: #2c3e50;
    line-height: 1;
}

.stat-label {
    font-size: 0.75rem;
    color: #6c757d;
    margin-top: 0.25rem;
}

/* Recent Grades */
.recent-grades {
    max-height: 200px;
    overflow-y: auto;
}

.grade-item {
    display: flex;
    justify-content: between;
    align-items: center;
    padding: 0.5rem 0;
    border-bottom: 1px solid #e9ecef;
}

.grade-item:last-child {
    border-bottom: none;
}

.grade-subject {
    flex: 1;
    font-weight: 500;
    color: #495057;
}

.grade-score {
    font-size: 0.875rem;
    font-weight: 600;
}

/* Buttons */
.btn-gradient-primary {
    background: linear-gradient(135deg, #667eea, #764ba2);
    border: none;
    color: white;
    border-radius: 12px;
    padding: 0.75rem 1.5rem;
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

.btn-outline-secondary {
    border: 2px solid #6c757d;
    border-radius: 12px;
    padding: 0.75rem 1.5rem;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-outline-secondary:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(108, 117, 125, 0.3);
}

/* Responsive */
@media (max-width: 768px) {
    .stats-grid {
        grid-template-columns: 1fr;
        gap: 0.75rem;
    }
    
    .profile-avatar-header {
        margin-top: 1rem;
    }
    
    .avatar-circle-header {
        width: 60px;
        height: 60px;
        font-size: 1.5rem;
    }
    
    .avatar-wrapper {
        width: 80px;
        height: 80px;
        font-size: 2rem;
    }
    
    .stat-item {
        padding: 0.75rem;
    }
}
</style>
@endsection