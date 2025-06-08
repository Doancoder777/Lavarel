<!DOCTYPE html>
<html lang="vi" class="h-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Student Portal')</title>
    
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        /* MODERN BEAUTIFUL LAYOUT */
        html, body {
            height: 100% !important;
            margin: 0;
            padding: 0;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }

        .layout-wrapper {
            display: flex;
            min-height: 100vh;
            background: #f8f9fa;
        }

        /* BEAUTIFUL SIDEBAR - DARK THEME */
        .sidebar-fixed {
            width: 280px;
            background: linear-gradient(180deg, #2c3e50 0%, #34495e 50%, #3d5a80 100%);
            color: white;
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            overflow-y: auto;
            z-index: 1000;
            display: flex;
            flex-direction: column;
            box-shadow: 4px 0 20px rgba(0,0,0,0.15);
        }

        /* User Profile Header */
        .sidebar-header {
            padding: 2rem 1.5rem;
            text-align: center;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            background: linear-gradient(135deg, rgba(52, 152, 219, 0.2), rgba(155, 89, 182, 0.2));
            backdrop-filter: blur(10px);
        }

        .user-avatar {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #3498db, #9b59b6);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            font-size: 2rem;
            font-weight: 700;
            color: white;
            border: 3px solid rgba(255,255,255,0.3);
            box-shadow: 0 8px 25px rgba(52, 152, 219, 0.3);
            position: relative;
        }

        .user-avatar::before {
            content: '';
            position: absolute;
            top: -5px;
            left: -5px;
            right: -5px;
            bottom: -5px;
            border-radius: 50%;
            background: linear-gradient(45deg, #3498db, #9b59b6, #e74c3c, #f39c12);
            z-index: -1;
            animation: rotate 4s linear infinite;
        }

        @keyframes rotate {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .user-info h4 {
            color: white;
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 0.25rem;
        }

        .user-info small {
            color: rgba(255,255,255,0.8);
            font-size: 0.9rem;
            background: rgba(255,255,255,0.1);
            padding: 0.25rem 0.75rem;
            border-radius: 15px;
            display: inline-block;
        }

        /* Navigation */
        .sidebar-nav {
            flex: 1;
            padding: 1.5rem 0;
        }

        .nav-item {
            margin-bottom: 0.5rem;
        }

        .nav-link {
            display: flex;
            align-items: center;
            padding: 1rem 1.5rem;
            color: rgba(255,255,255,0.8);
            text-decoration: none;
            transition: all 0.3s ease;
            border-left: 4px solid transparent;
            font-weight: 500;
            position: relative;
            margin: 0 0.5rem;
            border-radius: 10px;
        }

        .nav-link:hover {
            background: rgba(255,255,255,0.1);
            color: white;
            transform: translateX(8px);
            text-decoration: none;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        }

        .nav-link.active {
            background: linear-gradient(135deg, rgba(52, 152, 219, 0.3), rgba(155, 89, 182, 0.3));
            color: white;
            border-left-color: #3498db;
            font-weight: 600;
            box-shadow: 0 4px 15px rgba(52, 152, 219, 0.3);
        }

        .nav-link i {
            width: 20px;
            margin-right: 0.75rem;
            font-size: 1.1rem;
        }

        /* Sidebar Footer */
        .sidebar-footer {
            padding: 1.5rem;
            border-top: 1px solid rgba(255,255,255,0.1);
            background: rgba(0,0,0,0.2);
            margin-top: auto;
        }

        .logout-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            padding: 0.75rem;
            background: linear-gradient(135deg, #e74c3c, #c0392b);
            border: none;
            border-radius: 10px;
            color: white;
            font-weight: 500;
            transition: all 0.3s ease;
            cursor: pointer;
            box-shadow: 0 4px 15px rgba(231, 76, 60, 0.3);
        }

        .logout-btn:hover {
            background: linear-gradient(135deg, #c0392b, #a93226);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(231, 76, 60, 0.4);
            color: white;
        }

        .logout-btn i {
            margin-right: 0.5rem;
        }

        /* MAIN CONTENT */
        .main-content {
            flex: 1;
            margin-left: 280px;
            min-height: 100vh;
            background: #f8f9fa;
            display: flex;
            flex-direction: column;
        }

        /* BEAUTIFUL WELCOME HEADER */
        .welcome-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
            color: white;
            padding: 2rem;
            margin-bottom: 2rem;
            position: relative;
            overflow: hidden;
        }

        .welcome-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 100" fill="rgba(255,255,255,0.1)"><polygon points="1000,100 1000,0 0,100"/></svg>');
            background-size: cover;
        }

        .welcome-header h1 {
            font-size: 2rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            position: relative;
            z-index: 1;
        }

        .welcome-header p {
            margin: 0;
            opacity: 0.9;
            position: relative;
            z-index: 1;
        }

        /* Content Area */
        .content-area {
            flex: 1;
            padding: 0 2rem 2rem;
        }

        /* FOOTER - DOANCODER777 BRAND */
        .main-footer {
            background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
            color: white;
            padding: 1.5rem 2rem;
            text-align: center;
            margin-top: auto;
            border-top: 3px solid transparent;
            border-image: linear-gradient(90deg, #3498db, #9b59b6, #e74c3c) 1;
            position: relative;
        }

        .main-footer::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, #3498db, #9b59b6, #e74c3c, #f39c12);
            animation: gradient-slide 3s ease-in-out infinite;
        }

        @keyframes gradient-slide {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }

        .main-footer small {
            color: #bdc3c7;
        }

        .developer-brand {
            background: linear-gradient(45deg, #3498db, #9b59b6);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-weight: 700;
            font-size: 1.1em;
        }

        .code-icon {
            color: #3498db;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.8; transform: scale(1.1); }
            100% { opacity: 1; transform: scale(1); }
        }

        /* Mobile Responsive */
        @media (max-width: 768px) {
            .sidebar-fixed {
                width: 100%;
                transform: translateX(-100%);
                transition: transform 0.3s ease;
            }

            .sidebar-fixed.show {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }

            .mobile-toggle {
                display: block !important;
            }

            .welcome-header {
                padding: 1.5rem;
            }

            .content-area {
                padding: 0 1rem 1rem;
            }

            .main-footer {
                padding: 1rem;
                font-size: 0.9rem;
            }
        }

        .mobile-toggle {
            display: none;
            position: fixed;
            top: 1rem;
            left: 1rem;
            z-index: 1001;
            background: linear-gradient(135deg, #3498db, #9b59b6);
            color: white;
            border: none;
            padding: 0.75rem;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(52, 152, 219, 0.3);
            transition: all 0.3s ease;
        }

        .mobile-toggle:hover {
            transform: scale(1.1);
            box-shadow: 0 6px 20px rgba(52, 152, 219, 0.4);
        }

        /* Cards */
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 6px 20px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            overflow: hidden;
        }

        .card:hover {
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
            transform: translateY(-5px);
        }

        .card-header {
            background: linear-gradient(135deg, #f8f9fa, #e9ecef);
            border-bottom: 1px solid #e9ecef;
            padding: 1.25rem 1.5rem;
        }

        .card-body {
            padding: 1.5rem;
        }

        /* Alert Styles */
        .alert {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }

        /* Button Styles */
        .btn {
            border-radius: 10px;
            font-weight: 500;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0,0,0,0.15);
        }

        .btn-primary {
            background: linear-gradient(135deg, #3498db, #2980b9);
            border: none;
        }

        .btn-success {
            background: linear-gradient(135deg, #27ae60, #2ecc71);
            border: none;
        }

        .btn-warning {
            background: linear-gradient(135deg, #f39c12, #e67e22);
            border: none;
        }

        .btn-danger {
            background: linear-gradient(135deg, #e74c3c, #c0392b);
            border: none;
        }

        /* Table Styles */
        .table {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 6px 20px rgba(0,0,0,0.1);
        }

        .table thead th {
            border-bottom: 2px solid #e9ecef;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-size: 0.85rem;
            background: #f8f9fa;
        }
    </style>
</head>
<body class="h-100">
    <!-- Mobile Toggle -->
    <button class="mobile-toggle" onclick="toggleSidebar()">
        <i class="fas fa-bars"></i>
    </button>

    <div class="layout-wrapper">
        <!-- BEAUTIFUL SIDEBAR -->
        <nav class="sidebar-fixed" id="sidebar">
            <!-- User Profile -->
            <div class="sidebar-header">
                <div class="user-avatar">
                    {{ Auth::user() ? substr(Auth::user()->name, 0, 1) : 'U' }}
                </div>
                <div class="user-info">
                    <h4>{{ Auth::user()->name ?? 'User Name' }}</h4>
                    <small>{{ Auth::user()->student_id ?? 'SV000' }}</small>
                </div>
            </div>

            <!-- Navigation Menu -->
            <div class="sidebar-nav">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a href="{{ route('student.dashboard') }}" 
                           class="nav-link {{ request()->routeIs('student.dashboard') ? 'active' : '' }}">
                            <i class="fas fa-tachometer-alt"></i>
                            Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('student.grades') }}" 
                           class="nav-link {{ request()->routeIs('student.grades') ? 'active' : '' }}">
                            <i class="fas fa-chart-line"></i>
                            Xem điểm
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('student.enrollments') }}" 
                           class="nav-link {{ request()->routeIs('student.enrollments') ? 'active' : '' }}">
                            <i class="fas fa-book"></i>
                            Môn đã đăng ký
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('student.enroll.form') }}" 
                           class="nav-link {{ request()->routeIs('student.enroll*') ? 'active' : '' }}">
                            <i class="fas fa-plus-circle"></i>
                            Đăng ký môn học
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('student.profile') }}" 
                           class="nav-link {{ request()->routeIs('student.profile') ? 'active' : '' }}">
                            <i class="fas fa-user-edit"></i>
                            Hồ sơ cá nhân
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Logout Footer -->
            <div class="sidebar-footer">
                <form method="POST" action="{{ route('logout') }}" class="logout-form">
                    @csrf
                    <button type="submit" class="logout-btn" 
                            onclick="return confirm('Bạn có chắc muốn đăng xuất?')">
                        <i class="fas fa-sign-out-alt"></i>
                        Đăng xuất
                    </button>
                </form>
            </div>
        </nav>

        <!-- MAIN CONTENT -->
        <main class="main-content">
            <!-- Content Area -->
            <div class="content-area">
                <!-- Session Messages -->
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <!-- Page Content -->
                @yield('content')
            </div>

            <!-- BEAUTIFUL FOOTER -->
            <footer class="main-footer">
                <div class="container-fluid">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <small>
                                <i class="fas fa-code code-icon me-2"></i>
                                <strong>Laravel Student Management System</strong> - 
                                Product by <span class="developer-brand">Doancoder777</span>
                                © 2024 - 2025
                            </small>
                        </div>
                        <div class="col-md-4 text-end">
                            <small>
                                <i class="fas fa-laptop-code text-info me-1"></i>
                                Version 1.0.0
                                <span class="mx-2">|</span>
                                <i class="fab fa-laravel text-danger me-1"></i>
                                Laravel 11.x
                            </small>
                        </div>
                    </div>
                </div>
            </footer>
        </main>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Mobile sidebar toggle
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('show');
        }

        // Close sidebar on mobile when clicking outside
        document.addEventListener('click', function(event) {
            const sidebar = document.getElementById('sidebar');
            const toggle = document.querySelector('.mobile-toggle');
            
            if (window.innerWidth <= 768) {
                if (!sidebar.contains(event.target) && !toggle.contains(event.target)) {
                    sidebar.classList.remove('show');
                }
            }
        });

        // Handle window resize
        window.addEventListener('resize', function() {
            const sidebar = document.getElementById('sidebar');
            if (window.innerWidth > 768) {
                sidebar.classList.remove('show');
            }
        });

        // Auto-dismiss alerts
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                if (alert.classList.contains('show')) {
                    alert.style.transition = 'opacity 0.5s ease';
                    alert.style.opacity = '0';
                    setTimeout(() => {
                        if (alert.parentNode) {
                            alert.remove();
                        }
                    }, 500);
                }
            });
        }, 5000);

        // Footer animation
        window.addEventListener('load', function() {
            const footer = document.querySelector('.main-footer');
            footer.style.opacity = '0';
            footer.style.transform = 'translateY(20px)';
            footer.style.transition = 'all 0.8s ease';
            
            setTimeout(() => {
                footer.style.opacity = '1';
                footer.style.transform = 'translateY(0)';
            }, 500);
        });
    </script>

    @stack('scripts')
</body>
</html>