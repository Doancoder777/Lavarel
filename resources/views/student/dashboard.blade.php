@extends('layouts.student')

@section('title', 'Dashboard')

@section('content')
<div class="dashboard-wrapper">
    <!-- Welcome Header -->
    <div class="welcome-header">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="mb-2">
                    <span class="wave">👋</span> Chào mừng trở lại!
                </h1>
                <p class="mb-0 opacity-90">
                    <strong>{{ $student->name }}</strong> • {{ $student->student_id }} • {{ now()->format('d/m/Y') }}
                </p>
            </div>
            <div class="col-md-4 text-end">
                <div class="user-avatar-dashboard">
                    <div class="avatar-circle">
                        <span>{{ substr($student->name, 0, 1) }}</span>
                        <div class="avatar-glow"></div>
                    </div>
                    <div class="online-dot"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards - COLORFUL -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stat-card-colorful blue-card">
                <div class="stat-icon">
                    <i class="fas fa-book-open"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-number">{{ $stats['total_subjects'] }}</div>
                    <div class="stat-label">Tổng môn học</div>
                    <div class="stat-subtitle">đã đăng ký</div>
                </div>
                <div class="stat-wave blue-wave"></div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stat-card-colorful green-card">
                <div class="stat-icon">
                    <i class="fas fa-trophy"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-number">{{ $stats['completed_subjects'] }}</div>
                    <div class="stat-label">Hoàn thành</div>
                    <div class="stat-subtitle">môn học</div>
                </div>
                <div class="stat-wave green-wave"></div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stat-card-colorful orange-card">
                <div class="stat-icon">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-number">{{ $stats['active_enrollments'] }}</div>
                    <div class="stat-label">Đang học</div>
                    <div class="stat-subtitle">hiện tại</div>
                </div>
                <div class="stat-wave orange-wave"></div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stat-card-colorful purple-card">
                <div class="stat-icon">
                    <i class="fas fa-star"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-number">{{ number_format($stats['gpa'], 2) }}</div>
                    <div class="stat-label">GPA</div>
                    <div class="stat-subtitle">/ 4.00</div>
                </div>
                <div class="stat-wave purple-wave"></div>
            </div>
        </div>
    </div>

    <!-- Quick Actions - DIFFERENT COLORS -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-light border-0">
            <h5 class="mb-0">
                <i class="fas fa-bolt text-warning me-2"></i>
                Thao tác nhanh
            </h5>
            <small class="text-muted">Những việc bạn có thể làm ngay</small>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-lg-3 col-md-6 mb-3">
                    <a href="{{ route('student.grades') }}" class="action-link-colorful blue-action">
                        <div class="action-icon">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <div class="action-text">
                            <h6>Xem điểm số</h6>
                            <small>Kiểm tra kết quả học tập</small>
                        </div>
                        <i class="fas fa-arrow-right action-arrow"></i>
                    </a>
                </div>

                <div class="col-lg-3 col-md-6 mb-3">
                    <a href="{{ route('student.enroll.form') }}" class="action-link-colorful red-action">
                        <div class="action-icon">
                            <i class="fas fa-plus-circle"></i>
                        </div>
                        <div class="action-text">
                            <h6>Đăng ký môn học</h6>
                            <small>Thêm môn học mới</small>
                        </div>
                        <i class="fas fa-arrow-right action-arrow"></i>
                    </a>
                </div>

                <div class="col-lg-3 col-md-6 mb-3">
                    <a href="{{ route('student.enrollments') }}" class="action-link-colorful yellow-action">
                        <div class="action-icon">
                            <i class="fas fa-book"></i>
                        </div>
                        <div class="action-text">
                            <h6>Môn đã đăng ký</h6>
                            <small>Quản lý danh sách</small>
                        </div>
                        <i class="fas fa-arrow-right action-arrow"></i>
                    </a>
                </div>

                <div class="col-lg-3 col-md-6 mb-3">
                    <a href="{{ route('student.profile') }}" class="action-link-colorful indigo-action">
                        <div class="action-icon">
                            <i class="fas fa-user-edit"></i>
                        </div>
                        <div class="action-text">
                            <h6>Cập nhật hồ sơ</h6>
                            <small>Chỉnh sửa thông tin</small>
                        </div>
                        <i class="fas fa-arrow-right action-arrow"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="row">
        <!-- Recent Activities -->
        <div class="col-lg-8 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-light border-0">
                    <h5 class="mb-0">
                        <i class="fas fa-history text-primary me-2"></i>
                        Hoạt động gần đây
                    </h5>
                </div>
                <div class="card-body">
                    @if($enrollments->count() > 0)
                        <div class="activity-list">
                            @foreach($enrollments->take(5) as $index => $enrollment)
                            <div class="activity-item-colorful activity-{{ ($index % 4) + 1 }}">
                                <div class="activity-icon {{ strtolower($enrollment->status) }}">
                                    @if($enrollment->status == 'completed')
                                        <i class="fas fa-check-circle"></i>
                                    @elseif($enrollment->status == 'enrolled')
                                        <i class="fas fa-clock"></i>
                                    @else
                                        <i class="fas fa-times-circle"></i>
                                    @endif
                                </div>
                                <div class="activity-content">
                                    <h6 class="activity-title">{{ $enrollment->subject->subject_code }}</h6>
                                    <p class="activity-subtitle">{{ $enrollment->subject->subject_name }}</p>
                                    <div class="activity-meta">
                                        <span class="status-badge {{ strtolower($enrollment->status) }}">
                                            @if($enrollment->status == 'completed')
                                                Hoàn thành
                                            @elseif($enrollment->status == 'enrolled')
                                                Đang học
                                            @else
                                                {{ ucfirst($enrollment->status) }}
                                            @endif
                                        </span>
                                        <span class="activity-date">{{ $enrollment->created_at->format('d/m/Y') }}</span>
                                    </div>
                                </div>
                                <div class="activity-grade">
                                    @if($enrollment->grade)
                                        <span class="grade-badge-colorful">{{ $enrollment->grade->letter_grade }}</span>
                                        <small class="grade-score">{{ $enrollment->grade->total_score }}/10</small>
                                    @else
                                        <span class="no-grade">Chưa có điểm</span>
                                    @endif
                                </div>
                            </div>
                            @endforeach
                        </div>
                        
                        <div class="text-center mt-3">
                            <a href="{{ route('student.enrollments') }}" class="btn btn-primary">
                                <i class="fas fa-eye me-2"></i>
                                Xem tất cả
                            </a>
                        </div>
                    @else
                        <div class="empty-state">
                            <div class="empty-icon">📚</div>
                            <h4>Chưa có hoạt động nào</h4>
                            <p>Hãy bắt đầu bằng cách đăng ký môn học đầu tiên!</p>
                            <a href="{{ route('student.enroll.form') }}" class="btn btn-success">
                                <i class="fas fa-plus me-2"></i>
                                Đăng ký ngay
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Profile Summary -->
        <div class="col-lg-4 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-light border-0">
                    <h5 class="mb-0">
                        <i class="fas fa-user text-success me-2"></i>
                        Thông tin cá nhân
                    </h5>
                </div>
                <div class="card-body text-center">
                    <div class="profile-avatar-large mb-3">
                        <div class="avatar-wrapper">
                            <span>{{ substr($student->name, 0, 1) }}</span>
                            <div class="avatar-ring"></div>
                        </div>
                        <div class="online-indicator-large"></div>
                    </div>
                    
                    <h4 class="profile-name">{{ $student->name }}</h4>
                    <p class="profile-id text-muted">{{ $student->student_id }}</p>

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

                        <div class="detail-item">
                            <i class="fas fa-calendar text-info"></i>
                            <span>Tham gia {{ $student->created_at->format('d/m/Y') }}</span>
                        </div>
                    </div>

                    <div class="mt-3">
                        <a href="{{ route('student.profile') }}" class="btn btn-gradient">
                            <i class="fas fa-edit me-2"></i>
                            Chỉnh sửa hồ sơ
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Fill remaining space -->
    <div class="dashboard-filler"></div>
</div>

<style>
/* COLORFUL DASHBOARD STYLES */
.dashboard-wrapper {
    min-height: calc(100vh - 120px);
    background: #f8f9fa;
    padding-bottom: 2rem;
}

/* BEAUTIFUL AVATAR */
.user-avatar-dashboard {
    position: relative;
    display: flex;
    justify-content: center;
    align-items: center;
}

.avatar-circle {
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
    color: white;
    font-weight: 700;
    font-size: 1.5rem;
    box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
    transition: all 0.3s ease;
}

.avatar-circle:hover {
    transform: scale(1.1);
    box-shadow: 0 12px 35px rgba(102, 126, 234, 0.4);
}

.avatar-glow {
    position: absolute;
    top: -3px;
    left: -3px;
    right: -3px;
    bottom: -3px;
    border-radius: 50%;
    background: linear-gradient(45deg, #667eea, #764ba2, #f093fb, #f5576c);
    z-index: -1;
    animation: rotate 4s linear infinite;
}

@keyframes rotate {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

.online-dot {
    position: absolute;
    bottom: 5px;
    right: 5px;
    width: 14px;
    height: 14px;
    background: #00ff88;
    border-radius: 50%;
    border: 3px solid white;
    box-shadow: 0 0 10px rgba(0, 255, 136, 0.5);
    animation: pulse-green 2s infinite;
}

@keyframes pulse-green {
    0% { box-shadow: 0 0 0 0 rgba(0, 255, 136, 0.7); }
    70% { box-shadow: 0 0 0 10px rgba(0, 255, 136, 0); }
    100% { box-shadow: 0 0 0 0 rgba(0, 255, 136, 0); }
}

/* COLORFUL STAT CARDS */
.stat-card-colorful {
    background: white;
    border-radius: 20px;
    padding: 1.5rem;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
    border: none;
    height: 100%;
}

.stat-card-colorful:hover {
    transform: translateY(-10px);
    box-shadow: 0 20px 40px rgba(0,0,0,0.2);
}

.stat-card-colorful .stat-icon {
    width: 60px;
    height: 60px;
    border-radius: 15px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.8rem;
    color: white;
    margin-bottom: 1rem;
    box-shadow: 0 8px 20px rgba(0,0,0,0.2);
}

.blue-card .stat-icon { background: linear-gradient(135deg, #667eea, #764ba2); }
.green-card .stat-icon { background: linear-gradient(135deg, #56ab2f, #a8e6cf); }
.orange-card .stat-icon { background: linear-gradient(135deg, #ff9a56, #ffad56); }
.purple-card .stat-icon { background: linear-gradient(135deg, #a8edea, #fed6e3); }

.stat-number {
    font-size: 2.5rem;
    font-weight: 800;
    margin-bottom: 0.25rem;
}

.blue-card .stat-number { color: #667eea; }
.green-card .stat-number { color: #56ab2f; }
.orange-card .stat-number { color: #ff9a56; }
.purple-card .stat-number { color: #a8edea; }

.stat-label {
    font-weight: 600;
    color: #495057;
    margin-bottom: 0.25rem;
    font-size: 1.1rem;
}

.stat-subtitle {
    color: #6c757d;
    font-size: 0.9rem;
}

.stat-wave {
    position: absolute;
    bottom: 0;
    left: 0;
    width: 100%;
    height: 4px;
    background-size: 40px 40px;
    animation: wave-move 3s linear infinite;
}

.blue-wave { background: linear-gradient(90deg, #667eea, #764ba2); }
.green-wave { background: linear-gradient(90deg, #56ab2f, #a8e6cf); }
.orange-wave { background: linear-gradient(90deg, #ff9a56, #ffad56); }
.purple-wave { background: linear-gradient(90deg, #a8edea, #fed6e3); }

@keyframes wave-move {
    0% { background-position: 0 0; }
    100% { background-position: 40px 0; }
}

/* COLORFUL ACTION LINKS */
.action-link-colorful {
    background: white;
    border: none;
    border-radius: 15px;
    padding: 1.5rem;
    text-decoration: none;
    color: inherit;
    display: flex;
    align-items: center;
    gap: 1rem;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
    height: 100%;
    box-shadow: 0 8px 25px rgba(0,0,0,0.1);
}

.action-link-colorful:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 35px rgba(0,0,0,0.15);
    text-decoration: none;
    color: inherit;
}

.action-link-colorful .action-icon {
    width: 50px;
    height: 50px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.4rem;
    color: white;
    flex-shrink: 0;
    box-shadow: 0 6px 15px rgba(0,0,0,0.2);
}

.blue-action .action-icon { background: linear-gradient(135deg, #4facfe, #00f2fe); }
.red-action .action-icon { background: linear-gradient(135deg, #fa709a, #fee140); }
.yellow-action .action-icon { background: linear-gradient(135deg, #ffecd2, #fcb69f); }
.indigo-action .action-icon { background: linear-gradient(135deg, #667eea, #764ba2); }

.action-text h6 {
    margin-bottom: 0.25rem;
    font-weight: 600;
    color: #2c3e50;
    font-size: 1.1rem;
}

.action-text small {
    color: #6c757d;
    font-size: 0.9rem;
}

/* COLORFUL ACTIVITIES */
.activity-item-colorful {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1.5rem;
    border-radius: 15px;
    transition: all 0.3s ease;
    margin-bottom: 1rem;
    position: relative;
    overflow: hidden;
}

.activity-1 { background: linear-gradient(135deg, rgba(102, 126, 234, 0.1), rgba(118, 75, 162, 0.1)); }
.activity-2 { background: linear-gradient(135deg, rgba(86, 171, 47, 0.1), rgba(168, 230, 207, 0.1)); }
.activity-3 { background: linear-gradient(135deg, rgba(255, 154, 86, 0.1), rgba(255, 173, 86, 0.1)); }
.activity-4 { background: linear-gradient(135deg, rgba(168, 237, 234, 0.1), rgba(254, 214, 227, 0.1)); }

.activity-item-colorful:hover {
    transform: translateX(8px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.1);
}

.grade-badge-colorful {
    background: linear-gradient(135deg, #56ab2f, #a8e6cf);
    color: white;
    padding: 0.3rem 0.8rem;
    border-radius: 20px;
    font-weight: 700;
    font-size: 0.9rem;
    display: block;
    margin-bottom: 0.25rem;
    box-shadow: 0 4px 10px rgba(86, 171, 47, 0.3);
}

/* PROFILE AVATAR */
.profile-avatar-large {
    position: relative;
    display: inline-block;
}

.avatar-wrapper {
    width: 80px;
    height: 80px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 2rem;
    font-weight: 700;
    position: relative;
    box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
}

.avatar-ring {
    position: absolute;
    top: -5px;
    left: -5px;
    right: -5px;
    bottom: -5px;
    border-radius: 50%;
    border: 3px solid transparent;
    background: linear-gradient(45deg, #667eea, #764ba2, #f093fb) border-box;
    mask: linear-gradient(#fff 0 0) padding-box, linear-gradient(#fff 0 0);
    mask-composite: subtract;
    animation: rotate 6s linear infinite;
}

.online-indicator-large {
    position: absolute;
    bottom: 8px;
    right: 8px;
    width: 20px;
    height: 20px;
    background: #00ff88;
    border-radius: 50%;
    border: 4px solid white;
    box-shadow: 0 0 15px rgba(0, 255, 136, 0.5);
    animation: pulse-green 2s infinite;
}

.btn-gradient {
    background: linear-gradient(135deg, #667eea, #764ba2);
    border: none;
    color: white;
    font-weight: 600;
    padding: 0.75rem 1.5rem;
    border-radius: 10px;
    transition: all 0.3s ease;
    box-shadow: 0 6px 20px rgba(102, 126, 234, 0.3);
}

.btn-gradient:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 30px rgba(102, 126, 234, 0.4);
    color: white;
}

/* Wave Animation */
.wave {
    display: inline-block;
    animation: wave 2s ease-in-out infinite;
}

@keyframes wave {
    0%, 100% { transform: rotate(0deg); }
    25% { transform: rotate(20deg); }
    75% { transform: rotate(-10deg); }
}

/* Other existing styles... */
.dashboard-filler {
    min-height: 200px;
    background: #f8f9fa;
}

.activity-icon {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1rem;
    flex-shrink: 0;
}

.activity-icon.completed { background: #28a745; }
.activity-icon.enrolled { background: #007bff; }
.activity-icon.dropped { background: #6c757d; }

.activity-content {
    flex: 1;
}

.activity-title {
    font-weight: 600;
    color: #2c3e50;
    margin-bottom: 0.25rem;
    font-size: 1rem;
}

.activity-subtitle {
    color: #6c757d;
    font-size: 0.9rem;
    margin-bottom: 0.5rem;
}

.activity-meta {
    display: flex;
    gap: 1rem;
    align-items: center;
}

.status-badge {
    padding: 0.25rem 0.5rem;
    border-radius: 12px;
    font-size: 0.75rem;
    font-weight: 500;
    color: white;
}

.status-badge.completed { background: #28a745; }
.status-badge.enrolled { background: #007bff; }
.status-badge.dropped { background: #6c757d; }

.activity-date {
    color: #adb5bd;
    font-size: 0.8rem;
}

.activity-grade {
    text-align: center;
    flex-shrink: 0;
}

.grade-score {
    color: #6c757d;
    font-size: 0.75rem;
}

.no-grade {
    color: #adb5bd;
    font-size: 0.8rem;
}

.profile-name {
    font-size: 1.25rem;
    font-weight: 600;
    color: #2c3e50;
    margin-bottom: 0.25rem;
}

.profile-id {
    font-weight: 500;
}

.detail-item {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.5rem 0;
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

.empty-state {
    text-align: center;
    padding: 3rem 2rem;
}

.empty-icon {
    font-size: 3rem;
    margin-bottom: 1rem;
    opacity: 0.7;
}

.empty-state h4 {
    color: #495057;
    margin-bottom: 1rem;
}

.empty-state p {
    color: #6c757d;
    margin-bottom: 2rem;
}

.card {
    border: none;
    border-radius: 12px;
    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
}

.card:hover {
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
}

.card-header {
    background: #f8f9fa;
    border-bottom: 1px solid #e9ecef;
    border-radius: 12px 12px 0 0;
    padding: 1.25rem 1.5rem;
}

.card-header h5 {
    margin-bottom: 0.25rem;
}

.card-body {
    padding: 1.5rem;
}

/* Responsive */
@media (max-width: 768px) {
    .dashboard-wrapper {
        min-height: calc(100vh - 80px);
    }
    
    .action-link-colorful {
        flex-direction: column;
        text-align: center;
        gap: 0.5rem;
    }
    
    .action-arrow {
        display: none;
    }
    
    .stat-number {
        font-size: 2rem;
    }
    
    .avatar-circle {
        width: 50px;
        height: 50px;
        font-size: 1.25rem;
    }
}
</style>
@endsection