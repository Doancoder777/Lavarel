<!DOCTYPE html>
<html>
<head>
    <title>Login - Student Management</title>
    <style>
        body { font-family: Arial; padding: 50px; background: #f5f5f5; }
        .login-box { max-width: 400px; margin: 0 auto; background: white; padding: 30px; border-radius: 10px; }
        input { width: 100%; padding: 10px; margin: 10px 0; border: 1px solid #ddd; border-radius: 5px; }
        button { width: 100%; padding: 15px; background: #007bff; color: white; border: none; border-radius: 5px; }
        .error { color: red; margin: 10px 0; }
        .success { color: green; margin: 10px 0; }
        .test-accounts { background: #f8f9fa; padding: 15px; margin: 20px 0; border-radius: 5px; }
    </style>
</head>
<body>
    <div class="login-box">
        <h2>🎓 Đăng nhập hệ thống</h2>
        
        @if(session('success'))
            <div class="success">{{ session('success') }}</div>
        @endif
        
        @if(session('error'))
            <div class="error">{{ session('error') }}</div>
        @endif
        
        @if($errors->any())
            <div class="error">
                @foreach($errors->all() as $error)
                    {{ $error }}<br>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('login.post') }}">
            @csrf
            
            <input type="email" name="email" placeholder="Email" value="{{ old('email') }}" required>
            
            <input type="password" name="password" placeholder="Mật khẩu" required>
            
            <label>
                <input type="checkbox" name="remember"> Ghi nhớ đăng nhập
            </label>
            
            <button type="submit">Đăng nhập</button>
        </form>

        <div class="test-accounts">
            <h4>Tài khoản test:</h4>
            <p><strong>Admin:</strong> admin@school.edu.vn / admin123</p>
            <p><strong>Student:</strong> an@student.edu.vn / 123456</p>
        </div>
    </div>
</body>
</html>