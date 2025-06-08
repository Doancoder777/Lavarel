@extends('layouts.admin')

@section('title', 'Admin Dashboard')
@section('page-title', 'Dashboard')

@section('breadcrumb')
    <li class="breadcrumb-item active">Dashboard</li>
@endsection

@section('content')
<div class="modern-dashboard">
    <!-- Welcome Hero Section -->
    <div class="admin-hero">
        <div class="hero-content">
            <div class="hero-text">
                <h1 class="hero-title">
                    <span class="welcome-icon">🎯</span>
                    Welcome back, Admin!
                </h1>
                <p class="hero-subtitle">
                    Chào mừng <strong>{{ $admin->name }}</strong> - {{ now()->format('l, d/m/Y H:i') }}
                </p>
                <div class="hero-stats">
                    <span class="hero-stat">
                        <i class="fas fa-users text-primary"></i>
                        {{ $stats['total_students'] }} Students
                    </span>
                    <span class="hero-stat">
                        <i class="fas fa-book text-success"></i>
                        {{ $stats['total_subjects'] }} Subjects
                    </span>
                    <span class="hero-stat">
                        <i class="fas fa-chart-line text-info"></i>
                        {{ $stats['active_enrollments'] }} Active
                    </span>
                </div>
            </div>
            <div class="hero-actions">
                <a href="{{ route('admin.students.create') }}" class="btn btn-gradient-primary">
                    <i class="fas fa-plus me-2"></i>
                    Add Student
                </a>
                <a href="{{ route('admin.subjects.create') }}" class="btn btn-gradient-success">
                    <i class="fas fa-plus me-2"></i>
                    Add Subject
                </a>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="stats-grid">
        <div class="modern-stat-card primary-card">
            <div class="card-header">
                <div class="stat-icon primary-icon">
                    <i class="fas fa-user-graduate"></i>
                </div>
                <div class="stat-actions">
                    <div class="dropdown">
                        <button class="btn-icon" data-bs-toggle="dropdown">
                            <i class="fas fa-ellipsis-h"></i>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('admin.students') }}">View All</a></li>
                            <li><a class="dropdown-item" href="{{ route('admin.students.create') }}">Add New</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="stat-number">{{ $stats['total_students'] }}</div>
                <div class="stat-label">Total Students</div>
                <div class="stat-progress">
                    <div class="progress">
                        <div class="progress-bar bg-primary" style="width: 85%"></div>
                    </div>
                    <span class="progress-text">85% Active</span>
                </div>
            </div>
            <div class="card-footer">
                <span class="trend trend-up">
                    <i class="fas fa-arrow-up"></i>
                    +12% this month
                </span>
            </div>
        </div>

        <div class="modern-stat-card success-card">
            <div class="card-header">
                <div class="stat-icon success-icon">
                    <i class="fas fa-book"></i>
                </div>
                <div class="stat-actions">
                    <div class="dropdown">
                        <button class="btn-icon" data-bs-toggle="dropdown">
                            <i class="fas fa-ellipsis-h"></i>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('admin.subjects') }}">View All</a></li>
                            <li><a class="dropdown-item" href="{{ route('admin.subjects.create') }}">Add New</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="stat-number">{{ $stats['total_subjects'] }}</div>
                <div class="stat-label">Total Subjects</div>
                <div class="stat-progress">
                    <div class="progress">
                        <div class="progress-bar bg-success" style="width: 92%"></div>
                    </div>
                    <span class="progress-text">92% Active</span>
                </div>
            </div>
            <div class="card-footer">
                <span class="trend trend-up">
                    <i class="fas fa-arrow-up"></i>
                    +3 new subjects
                </span>
            </div>
        </div>

        <div class="modern-stat-card info-card">
            <div class="card-header">
                <div class="stat-icon info-icon">
                    <i class="fas fa-clipboard-list"></i>
                </div>
                <div class="stat-actions">
                    <div class="dropdown">
                        <button class="btn-icon" data-bs-toggle="dropdown">
                            <i class="fas fa-ellipsis-h"></i>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('admin.enrollments') }}">View All</a></li>
                            <li><a class="dropdown-item" href="#">Manage</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="stat-number">{{ $stats['total_enrollments'] }}</div>
                <div class="stat-label">Total Enrollments</div>
                <div class="stat-progress">
                    <div class="progress">
                        <div class="progress-bar bg-info" style="width: 78%"></div>
                    </div>
                    <span class="progress-text">78% Completed</span>
                </div>
            </div>
            <div class="card-footer">
                <span class="trend trend-stable">
                    <i class="fas fa-minus"></i>
                    Stable this week
                </span>
            </div>
        </div>

        <div class="modern-stat-card warning-card">
            <div class="card-header">
                <div class="stat-icon warning-icon">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="stat-actions">
                    <div class="dropdown">
                        <button class="btn-icon" data-bs-toggle="dropdown">
                            <i class="fas fa-ellipsis-h"></i>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('admin.enrollments') }}?status=enrolled">View Active</a></li>
                            <li><a class="dropdown-item" href="#">Monitor</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="stat-number">{{ $stats['active_enrollments'] }}</div>
                <div class="stat-label">Active Enrollments</div>
                <div class="stat-progress">
                    <div class="progress">
                        <div class="progress-bar bg-warning" style="width: 65%"></div>
                    </div>
                    <span class="progress-text">65% In Progress</span>
                </div>
            </div>
            <div class="card-footer">
                <span class="trend trend-down">
                    <i class="fas fa-arrow-down"></i>
                    -5% from last week
                </span>
            </div>
        </div>
    </div>

    <!-- Quick Actions & Recent Activities -->
    <div class="content-grid">
        <!-- Quick Actions Panel -->
        <div class="quick-actions-panel">
            <div class="panel-header">
                <h3 class="panel-title">
                    <i class="fas fa-bolt text-warning me-2"></i>
                    Quick Actions
                </h3>
            </div>
            <div class="panel-body">
                <div class="action-grid">
                    <a href="{{ route('admin.students') }}" class="action-card">
                        <div class="action-icon primary-action">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="action-content">
                            <div class="action-title">Manage Students</div>
                            <div class="action-subtitle">View, add, edit students</div>
                        </div>
                        <div class="action-arrow">
                            <i class="fas fa-chevron-right"></i>
                        </div>
                    </a>

                    <a href="{{ route('admin.subjects') }}" class="action-card">
                        <div class="action-icon success-action">
                            <i class="fas fa-book"></i>
                        </div>
                        <div class="action-content">
                            <div class="action-title">Manage Subjects</div>
                            <div class="action-subtitle">Course management</div>
                        </div>
                        <div class="action-arrow">
                            <i class="fas fa-chevron-right"></i>
                        </div>
                    </a>

                    <a href="{{ route('admin.enrollments') }}" class="action-card">
                        <div class="action-icon info-action">
                            <i class="fas fa-clipboard-list"></i>
                        </div>
                        <div class="action-content">
                            <div class="action-title">View Enrollments</div>
                            <div class="action-subtitle">Student registrations</div>
                        </div>
                        <div class="action-arrow">
                            <i class="fas fa-chevron-right"></i>
                        </div>
                    </a>

                    <a href="{{ route('admin.reports') }}" class="action-card">
                        <div class="action-icon warning-action">
                            <i class="fas fa-chart-bar"></i>
                        </div>
                        <div class="action-content">
                            <div class="action-title">View Reports</div>
                            <div class="action-subtitle">Analytics & insights</div>
                        </div>
                        <div class="action-arrow">
                            <i class="fas fa-chevron-right"></i>
                        </div>
                    </a>
                </div>
            </div>
        </div>

        <!-- Recent Activities -->
        <div class="recent-activities-panel">
            <div class="panel-header">
                <h3 class="panel-title">
                    <i class="fas fa-clock text-info me-2"></i>
                    Recent Activities
                </h3>
                <div class="panel-actions">
                    <button class="btn btn-sm btn-outline-primary">
                        <i class="fas fa-refresh me-1"></i>
                        Refresh
                    </button>
                </div>
            </div>
            <div class="panel-body">
                <div class="activity-timeline">
                    @if($recent_enrollments->count() > 0)
                        @foreach($recent_enrollments->take(5) as $enrollment)
                        <div class="timeline-item">
                            <div class="timeline-marker enrolled-marker">
                                <i class="fas fa-user-plus"></i>
                            </div>
                            <div class="timeline-content">
                                <div class="timeline-header">
                                    <span class="timeline-title">New Enrollment</span>
                                    <span class="timeline-time">{{ $enrollment->created_at->diffForHumans() }}</span>
                                </div>
                                <div class="timeline-description">
                                    <strong>{{ $enrollment->student->name }}</strong> enrolled in 
                                    <strong>{{ $enrollment->subject->subject_name }}</strong>
                                </div>
                                <div class="timeline-meta">
                                    <span class="badge bg-primary">{{ $enrollment->semester }}</span>
                                    <span class="badge bg-success">{{ ucfirst($enrollment->status) }}</span>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    @endif

                    @if($recent_grades->count() > 0)
                        @foreach($recent_grades->take(3) as $grade)
                        <div class="timeline-item">
                            <div class="timeline-marker graded-marker">
                                <i class="fas fa-star"></i>
                            </div>
                            <div class="timeline-content">
                                <div class="timeline-header">
                                    <span class="timeline-title">Grade Added</span>
                                    <span class="timeline-time">{{ $grade->created_at->diffForHumans() }}</span>
                                </div>
                                <div class="timeline-description">
                                    <strong>{{ $grade->enrollment->student->name }}</strong> received grade for 
                                    <strong>{{ $grade->enrollment->subject->subject_name }}</strong>
                                </div>
                                <div class="timeline-meta">
                                    <span class="badge bg-warning">Grade: {{ $grade->letter_grade }}</span>
                                    <span class="badge bg-info">GPA: {{ $grade->gpa_value }}</span>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    @endif
                </div>

                <div class="activity-footer">
                    <a href="{{ route('admin.enrollments') }}" class="btn btn-link">
                        View All Activities <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Performance Chart -->
    <div class="chart-panel">
        <div class="panel-header">
            <h3 class="panel-title">
                <i class="fas fa-chart-line text-success me-2"></i>
                System Performance
            </h3>
            <div class="panel-actions">
                <div class="btn-group">
                    <button class="btn btn-sm btn-outline-secondary active">Week</button>
                    <button class="btn btn-sm btn-outline-secondary">Month</button>
                    <button class="btn btn-sm btn-outline-secondary">Year</button>
                </div>
            </div>
        </div>
        <div class="panel-body">
            <div class="chart-container">
                <canvas id="performanceChart"></canvas>
            </div>
        </div>
    </div>
</div>

<style>
.modern-dashboard {
    padding: 0;
}

/* Hero Section */
.admin-hero {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 20px;
    padding: 2rem;
    margin-bottom: 2rem;
    color: white;
    position: relative;
    overflow: hidden;
}

.admin-hero::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><circle cx="25" cy="25" r="1" fill="white" opacity="0.1"/><circle cx="75" cy="75" r="1" fill="white" opacity="0.1"/></svg>');
    opacity: 0.3;
}

.hero-content {
    display: flex;
    justify-content: space-between;
    align-items: center;
    position: relative;
    z-index: 1;
}

.hero-title {
    font-size: 2.5rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
}

.welcome-icon {
    display: inline-block;
    animation: wave 2s ease-in-out infinite;
}

@keyframes wave {
    0%, 100% { transform: rotate(0deg); }
    25% { transform: rotate(20deg); }
    75% { transform: rotate(-10deg); }
}

.hero-subtitle {
    font-size: 1.1rem;
    margin-bottom: 1rem;
    opacity: 0.9;
}

.hero-stats {
    display: flex;
    gap: 2rem;
    margin-top: 1rem;
}

.hero-stat {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    background: rgba(255,255,255,0.1);
    padding: 0.5rem 1rem;
    border-radius: 25px;
    backdrop-filter: blur(10px);
}

.hero-actions {
    display: flex;
    gap: 1rem;
}

.btn-gradient-primary {
    background: linear-gradient(45deg, #007bff, #00d4ff);
    border: none;
    color: white;
    padding: 0.75rem 1.5rem;
    border-radius: 12px;
    font-weight: 600;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(0,123,255,0.3);
}

.btn-gradient-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0,123,255,0.4);
    color: white;
}

.btn-gradient-success {
    background: linear-gradient(45deg, #28a745, #20c997);
    border: none;
    color: white;
    padding: 0.75rem 1.5rem;
    border-radius: 12px;
    font-weight: 600;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(40,167,69,0.3);
}

.btn-gradient-success:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(40,167,69,0.4);
    color: white;
}

/* Stats Grid */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.modern-stat-card {
    background: white;
    border-radius: 20px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
    overflow: hidden;
    position: relative;
}

.modern-stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 20px 40px rgba(0,0,0,0.15);
}

.primary-card {
    border-top: 4px solid #007bff;
}

.success-card {
    border-top: 4px solid #28a745;
}

.info-card {
    border-top: 4px solid #17a2b8;
}

.warning-card {
    border-top: 4px solid #ffc107;
}

.card-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1.5rem 1.5rem 0;
}

.stat-icon {
    width: 60px;
    height: 60px;
    border-radius: 15px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    color: white;
}

.primary-icon {
    background: linear-gradient(45deg, #007bff, #0056b3);
}

.success-icon {
    background: linear-gradient(45deg, #28a745, #1e7e34);
}

.info-icon {
    background: linear-gradient(45deg, #17a2b8, #117a8b);
}

.warning-icon {
    background: linear-gradient(45deg, #ffc107, #e0a800);
}

.btn-icon {
    background: none;
    border: none;
    color: #6c757d;
    padding: 0.5rem;
    border-radius: 8px;
    transition: all 0.2s ease;
}

.btn-icon:hover {
    background: #f8f9fa;
    color: #495057;
}

.card-body {
    padding: 1rem 1.5rem;
}

.stat-number {
    font-size: 2.5rem;
    font-weight: 700;
    color: #2c3e50;
    margin-bottom: 0.5rem;
}

.stat-label {
    font-size: 1.1rem;
    color: #6c757d;
    margin-bottom: 1rem;
}

.stat-progress {
    margin-bottom: 1rem;
}

.progress {
    height: 8px;
    border-radius: 10px;
    background: #e9ecef;
    overflow: hidden;
}

.progress-bar {
    border-radius: 10px;
    transition: width 0.6s ease;
}

.progress-text {
    font-size: 0.85rem;
    color: #6c757d;
    margin-top: 0.5rem;
    display: block;
}

.card-footer {
    padding: 0 1.5rem 1.5rem;
}

.trend {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.9rem;
    font-weight: 600;
}

.trend-up {
    color: #28a745;
}

.trend-down {
    color: #dc3545;
}

.trend-stable {
    color: #6c757d;
}

/* Content Grid */
.content-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 2rem;
    margin-bottom: 2rem;
}

.quick-actions-panel,
.recent-activities-panel {
    background: white;
    border-radius: 20px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    overflow: hidden;
}

.panel-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1.5rem;
    border-bottom: 1px solid #e9ecef;
    background: #f8f9fa;
}

.panel-title {
    font-size: 1.25rem;
    font-weight: 600;
    margin: 0;
    color: #2c3e50;
}

.panel-body {
    padding: 1.5rem;
}

.action-grid {
    display: grid;
    gap: 1rem;
}

.action-card {
    display: flex;
    align-items: center;
    padding: 1rem;
    border: 1px solid #e9ecef;
    border-radius: 12px;
    text-decoration: none;
    color: inherit;
    transition: all 0.3s ease;
}

.action-card:hover {
    transform: translateX(5px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    border-color: #007bff;
    color: inherit;
    text-decoration: none;
}

.action-icon {
    width: 50px;
    height: 50px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
    color: white;
    margin-right: 1rem;
}

.primary-action {
    background: linear-gradient(45deg, #007bff, #0056b3);
}

.success-action {
    background: linear-gradient(45deg, #28a745, #1e7e34);
}

.info-action {
    background: linear-gradient(45deg, #17a2b8, #117a8b);
}

.warning-action {
    background: linear-gradient(45deg, #ffc107, #e0a800);
}

.action-content {
    flex: 1;
}

.action-title {
    font-weight: 600;
    color: #2c3e50;
    margin-bottom: 0.25rem;
}

.action-subtitle {
    font-size: 0.9rem;
    color: #6c757d;
}

.action-arrow {
    color: #6c757d;
    opacity: 0;
    transition: all 0.3s ease;
}

.action-card:hover .action-arrow {
    opacity: 1;
    transform: translateX(5px);
}

/* Timeline */
.activity-timeline {
    position: relative;
}

.timeline-item {
    display: flex;
    margin-bottom: 1.5rem;
    position: relative;
}

.timeline-marker {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 1rem;
    font-size: 0.9rem;
    color: white;
    flex-shrink: 0;
}

.enrolled-marker {
    background: linear-gradient(45deg, #007bff, #0056b3);
}

.graded-marker {
    background: linear-gradient(45deg, #ffc107, #e0a800);
}

.timeline-content {
    flex: 1;
}

.timeline-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 0.5rem;
}

.timeline-title {
    font-weight: 600;
    color: #2c3e50;
}

.timeline-time {
    font-size: 0.85rem;
    color: #6c757d;
}

.timeline-description {
    color: #495057;
    margin-bottom: 0.5rem;
}

.timeline-meta {
    display: flex;
    gap: 0.5rem;
}

.activity-footer {
    text-align: center;
    padding-top: 1rem;
    border-top: 1px solid #e9ecef;
    margin-top: 1rem;
}

/* Chart Panel */
.chart-panel {
    background: white;
    border-radius: 20px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    overflow: hidden;
}

.chart-container {
    height: 300px;
    padding: 1rem;
}

/* Responsive */
@media (max-width: 768px) {
    .hero-content {
        flex-direction: column;
        text-align: center;
        gap: 1.5rem;
    }

    .hero-stats {
        flex-direction: column;
        gap: 1rem;
    }

    .stats-grid {
        grid-template-columns: 1fr;
    }

    .content-grid {
        grid-template-columns: 1fr;
    }

    .hero-actions {
        flex-direction: column;
        width: 100%;
    }
}
</style>

<script>
// Performance Chart
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('performanceChart');
    if (ctx) {
        new Chart(ctx.getContext('2d'), {
            type: 'line',
            data: {
                labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                datasets: [{
                    label: 'Enrollments',
                    data: [12, 19, 15, 17, 14, 16, 18],
                    borderColor: '#007bff',
                    backgroundColor: 'rgba(0,123,255,0.1)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4
                }, {
                    label: 'Completions',
                    data: [8, 12, 10, 14, 11, 13, 15],
                    borderColor: '#28a745',
                    backgroundColor: 'rgba(40,167,69,0.1)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: '#e9ecef'
                        }
                    },
                    x: {
                        grid: {
                            color: '#e9ecef'
                        }
                    }
                }
            }
        });
    }
});
</script>
@endsection