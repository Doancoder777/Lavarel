@extends('layouts.auth')

@section('title', 'Đăng nhập - Student Management System')

@section('content')
    <div class="auth-header">
        <div class="auth-title">🎓 Đăng nhập hệ thống</div>
        <div class="auth-subtitle">Student Management System</div>
    </div>

    {{-- Hiển thị thông báo lỗi --}}
    @if($errors->any())
        <div class="alert alert-danger">
            @foreach($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    {{-- Hiển thị thông báo thành công --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="{{ route('login.post') }}">
        @csrf
        <div class="form-group">
            <input type="email" name="email" class="form-input" placeholder="📧 Email" value="{{ old('email') }}" required autofocus>
        </div>
        <div class="form-group">
            <input type="password" name="password" class="form-input" placeholder="🔒 Mật khẩu" required>
        </div>
        <div class="form-group">
            <label style="color: #fff; font-size: 0.97rem;">
                <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                Ghi nhớ đăng nhập
            </label>
        </div>
        <div class="form-group">
            <button type="submit" class="btn-primary">Đăng nhập</button>
        </div>
    </form>

    <div class="form-group" style="margin-top: 10px;">
        <div class="test-accounts" style="background: rgba(255,255,255,0.07); border-radius: 12px; padding: 18px;">
            <h4 style="color: #fff; margin-bottom: 10px;">🚀 Tài khoản test nhanh</h4>
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                <span style="color: #fff;">👨‍💼 Admin: admin@school.edu.vn / admin123</span>
                <button class="btn-secondary" type="button" onclick="fillAdmin()">Điền nhanh</button>
            </div>
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <span style="color: #fff;">👨‍🎓 Student: binh@student.edu.vn / 123456</span>
                <button class="btn-secondary" type="button" onclick="fillStudent()">Điền nhanh</button>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    function fillAdmin() {
        document.querySelector('input[name="email"]').value = "admin@school.edu.vn";
        document.querySelector('input[name="password"]').value = "admin123";
    }
    function fillStudent() {
        document.querySelector('input[name="email"]').value = "binh@student.edu.vn";
        document.querySelector('input[name="password"]').value = "123456";
    }
</script>
@endpush
