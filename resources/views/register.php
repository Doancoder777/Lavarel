<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Đăng ký - Hệ thống quản lý sinh viên</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            padding: 2rem 0;
        }
        
        .register-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            padding: 2rem;
            width: 100%;
            max-width: 500px;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .register-header {
            text-align: center;
            margin-bottom: 2rem;
        }
        
        .register-header h2 {
            color: #333;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }
        
        .register-header p {
            color: #666;
            font-size: 0.95rem;
        }
        
        .form-floating {
            margin-bottom: 1rem;
        }
        
        .form-control {
            border-radius: 10px;
            border: 2px solid #e0e0e0;
            transition: all 0.3s ease;
        }
        
        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }
        
        .btn-register {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 10px;
            padding: 12px;
            font-weight: 600;
            transition: all 0.3s ease;
            width: 100%;
        }
        
        .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
        }
        
        .alert {
            border-radius: 10px;
            border: none;
            font-size: 0.9rem;
        }
        
        .icon-input {
            position: relative;
        }
        
        .icon-input i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #999;
            z-index: 3;
        }
        
        .icon-input .form-control {
            padding-left: 45px;
        }
        
        .password-strength {
            margin-top: 0.5rem;
            font-size: 0.8rem;
        }
        
        .strength-bar {
            height: 4px;
            border-radius: 2px;
            margin: 0.25rem 0;
            transition: all 0.3s ease;
        }
        
        .floating-shapes {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: -1;
        }
        
        .shape {
            position: absolute;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            animation: float 6s ease-in-out infinite;
        }
        
        .shape:nth-child(1) {
            width: 80px;
            height: 80px;
            top: 20%;
            left: 10%;
            animation-delay: 0s;
        }
        
        .shape:nth-child(2) {
            width: 60px;
            height: 60px;
            top: 60%;
            right: 15%;
            animation-delay: 2s;
        }
        
        .shape:nth-child(3) {
            width: 40px;
            height: 40px;
            bottom: 20%;
            left: 20%;
            animation-delay: 4s;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
    </style>
</head>
<body>
    <!-- Floating background shapes -->
    <div class="floating-shapes">
        <div class="shape"></div>
        <div class="shape"></div>
        <div class="shape"></div>
    </div>

    <div class="register-container">
        <div class="register-header">
            <i class="fas fa-user-plus fa-3x text-primary mb-3"></i>
            <h2>Đăng ký tài khoản</h2>
            <p>Tạo tài khoản sinh viên mới</p>
        </div>

        <!-- Success/Error Messages -->
        @if(session('success'))
            <div class="alert alert-success" role="alert">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
            </div>
        @endif

        <form method="POST" action="{{ route('register.post') }}" id="registerForm">
            @csrf
            
            <!-- Name Input -->
            <div class="form-floating mb-3">
                <div class="icon-input">
                    <i class="fas fa-user"></i>
                    <input type="text" 
                           class="form-control @error('name') is-invalid @enderror" 
                           id="name" 
                           name="name" 
                           placeholder="Họ và tên"
                           value="{{ old('name') }}"
                           required 
                           autofocus>
                    <label for="name">Họ và tên</label>
                </div>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Student ID Input -->
            <div class="form-floating mb-3">
                <div class="icon-input">
                    <i class="fas fa-id-card"></i>
                    <input type="text" 
                           class="form-control @error('student_id') is-invalid @enderror" 
                           id="student_id" 
                           name="student_id" 
                           placeholder="Mã sinh viên"
                           value="{{ old('student_id') }}">
                    <label for="student_id">Mã sinh viên (tùy chọn)</label>
                </div>
                @error('student_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <div class="form-text">Ví dụ: SV006, SV007...</div>
            </div>

            <!-- Email Input -->
            <div class="form-floating mb-3">
                <div class="icon-input">
                    <i class="fas fa-envelope"></i>
                    <input type="email" 
                           class="form-control @error('email') is-invalid @enderror" 
                           id="email" 
                           name="email" 
                           placeholder="name@example.com"
                           value="{{ old('email') }}"
                           required>
                    <label for="email">Email</label>
                </div>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Password Input -->
            <div class="form-floating mb-3">
                <div class="icon-input">
                    <i class="fas fa-lock"></i>
                    <input type="password" 
                           class="form-control @error('password') is-invalid @enderror" 
                           id="password" 
                           name="password" 
                           placeholder="Password"
                           required
                           onkeyup="checkPasswordStrength()">
                    <label for="password">Mật khẩu</label>
                </div>
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                
                <!-- Password Strength Indicator -->
                <div class="password-strength" id="passwordStrength">
                    <div class="strength-bar bg-light" id="strengthBar"></div>
                    <small class="text-muted" id="strengthText">Nhập mật khẩu để kiểm tra độ mạnh</small>
                </div>
            </div>

            <!-- Confirm Password Input -->
            <div class="form-floating mb-3">
                <div class="icon-input">
                    <i class="fas fa-lock"></i>
                    <input type="password" 
                           class="form-control @error('password_confirmation') is-invalid @enderror" 
                           id="password_confirmation" 
                           name="password_confirmation" 
                           placeholder="Confirm Password"
                           required
                           onkeyup="checkPasswordMatch()">
                    <label for="password_confirmation">Xác nhận mật khẩu</label>
                </div>
                @error('password_confirmation')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <div class="form-text" id="passwordMatch"></div>
            </div>

            <!-- Register Button -->
            <button type="submit" class="btn btn-primary btn-register" id="registerBtn">
                <i class="fas fa-user-plus me-2"></i>Đăng ký
            </button>
        </form>

        <!-- Login Link -->
        <div class="text-center mt-3">
            <p class="mb-0">Đã có tài khoản? 
                <a href="{{ route('login') }}" class="text-decoration-none">Đăng nhập ngay</a>
            </p>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Password strength checker
        function checkPasswordStrength() {
            const password = document.getElementById('password').value;
            const strengthBar = document.getElementById('strengthBar');
            const strengthText = document.getElementById('strengthText');
            
            let strength = 0;
            let feedback = '';
            
            // Check password criteria
            if (password.length >= 8) strength += 1;
            if (password.match(/[a-z]/)) strength += 1;
            if (password.match(/[A-Z]/)) strength += 1;
            if (password.match(/[0-9]/)) strength += 1;
            if (password.match(/[^a-zA-Z0-9]/)) strength += 1;
            
            // Update strength indicator
            switch(strength) {
                case 0:
                case 1:
                    strengthBar.className = 'strength-bar bg-danger';
                    strengthBar.style.width = '20%';
                    feedback = 'Mật khẩu rất yếu';
                    break;
                case 2:
                    strengthBar.className = 'strength-bar bg-warning';
                    strengthBar.style.width = '40%';
                    feedback = 'Mật khẩu yếu';
                    break;
                case 3:
                    strengthBar.className = 'strength-bar bg-info';
                    strengthBar.style.width = '60%';
                    feedback = 'Mật khẩu trung bình';
                    break;
                case 4:
                    strengthBar.className = 'strength-bar bg-primary';
                    strengthBar.style.width = '80%';
                    feedback = 'Mật khẩu mạnh';
                    break;
                case 5:
                    strengthBar.className = 'strength-bar bg-success';
                    strengthBar.style.width = '100%';
                    feedback = 'Mật khẩu rất mạnh';
                    break;
            }
            
            strengthText.textContent = feedback;
            strengthText.className = strengthBar.className.replace('strength-bar', 'text');
        }
        
        // Password match checker
        function checkPasswordMatch() {
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('password_confirmation').value;
            const matchText = document.getElementById('passwordMatch');
            
            if (confirmPassword === '') {
                matchText.textContent = '';
                return;
            }
            
            if (password === confirmPassword) {
                matchText.innerHTML = '<i class="fas fa-check text-success me-1"></i>Mật khẩu khớp';
                matchText.className = 'form-text text-success';
            } else {
                matchText.innerHTML = '<i class="fas fa-times text-danger me-1"></i>Mật khẩu không khớp';
                matchText.className = 'form-text text-danger';
            }
        }

        // Form submission handling
        document.getElementById('registerForm').addEventListener('submit', function(e) {
            const registerBtn = document.getElementById('registerBtn');
            registerBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Đang đăng ký...';
            registerBtn.disabled = true;
        });

        // Auto-hide alerts after 5 seconds
        setTimeout(() => {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                alert.style.transition = 'opacity 0.5s ease';
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 500);
            });
        }, 5000);
    </script>
</body>
</html>