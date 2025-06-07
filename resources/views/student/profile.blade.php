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
                Cập nhật thông tin cá nhân và mật khẩu
            </p>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('student.dashboard') }}" class="btn btn-light btn-lg">
                <i class="fas fa-arrow-left"></i> Về Dashboard
            </a>
        </div>
    </div>
</div>

<div class="row">
    <!-- Profile Information -->
    <div class="col-lg-8 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-light border-0">
                <h5 class="mb-0">
                    <i class="fas fa-user text-primary"></i> Thông tin cá nhân
                </h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('student.profile.update') }}">
                    @csrf
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="name" class="form-label">Họ và tên *</label>
                            <input type="text" 
                                   class="form-control @error('name') is-invalid @enderror" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name', $student->name) }}" 
                                   required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="student_id" class="form-label">Mã sinh viên</label>
                            <input type="text" 
                                   class="form-control" 
                                   id="student_id" 
                                   value="{{ $student->student_id }}" 
                                   readonly
                                   style="background-color: #f8f9fa;">
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" 
                                   class="form-control" 
                                   id="email" 
                                   value="{{ $student->email }}" 
                                   readonly
                                   style="background-color: #f8f9fa;">
                            <small class="form-text text-muted">Email không thể thay đổi</small>
                        </div>
                        <div class="col-md-6">
                            <label for="phone" class="form-label">Số điện thoại</label>
                            <input type="text" 
                                   class="form-control @error('phone') is-invalid @enderror" 
                                   id="phone" 
                                   name="phone" 
                                   value="{{ old('phone', $student->phone) }}"
                                   placeholder="Nhập số điện thoại">
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="address" class="form-label">Địa chỉ</label>
                        <textarea class="form-control @error('address') is-invalid @enderror" 
                                  id="address" 
                                  name="address" 
                                  rows="3"
                                  placeholder="Nhập địa chỉ của bạn">{{ old('address', $student->address) }}</textarea>
                        @error('address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="text-end">
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save"></i> Cập nhật thông tin
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Profile Summary -->
    <div class="col-lg-4 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-light border-0">
                <h5 class="mb-0">
                    <i class="fas fa-id-card text-success"></i> Thông tin hiện tại
                </h5>
            </div>
            <div class="card-body text-center">
                <div class="mb-3">
                    <i class="fas fa-user-circle fa-5x text-success mb-3"></i>
                    <h5>{{ $student->name }}</h5>
                    <p class="text-muted">{{ $student->student_id }}</p>
                </div>
                
                <hr>
                
                <div class="text-start">
                    <div class="mb-2">
                        <i class="fas fa-envelope text-muted me-2"></i>
                        <small>{{ $student->email }}</small>
                    </div>
                    
                    @if($student->phone)
                    <div class="mb-2">
                        <i class="fas fa-phone text-muted me-2"></i>
                        <small>{{ $student->phone }}</small>
                    </div>
                    @endif
                    
                    @if($student->address)
                    <div class="mb-2">
                        <i class="fas fa-map-marker-alt text-muted me-2"></i>
                        <small>{{ $student->address }}</small>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        
        <!-- Academic Summary -->
        <div class="card border-0 shadow-sm mt-4">
            <div class="card-header bg-light border-0">
                <h5 class="mb-0">
                    <i class="fas fa-graduation-cap text-info"></i> Tóm tắt học tập
                </h5>
            </div>
            <div class="card-body">
                @php
                    $enrollments = $student->enrollments;
                    $completedCount = $enrollments->where('status', 'completed')->count();
                    $activeCount = $enrollments->where('status', 'enrolled')->count();
                    $avgGpa = $enrollments->filter(function($e) { 
                        return $e->grade && $e->grade->gpa_value; 
                    })->avg('grade.gpa_value');
                @endphp
                
                <div class="d-flex justify-content-between mb-2">
                    <small>Môn đã hoàn thành:</small>
                    <span class="badge bg-success">{{ $completedCount }}</span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <small>Môn đang học:</small>
                    <span class="badge bg-warning">{{ $activeCount }}</span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <small>GPA trung bình:</small>
                    <span class="badge bg-primary">{{ $avgGpa ? number_format($avgGpa, 2) : '0.00' }}</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Change Password Section -->
<div class="row">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-light border-0">
                <h5 class="mb-0">
                    <i class="fas fa-lock text-warning"></i> Đổi mật khẩu
                </h5>
            </div>
            <div class="card-body">
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle"></i>
                    <strong>Lưu ý:</strong> Để đảm bảo bảo mật, hãy sử dụng mật khẩu mạnh có ít nhất 6 ký tự.
                </div>
                
                <form method="POST" action="{{ route('student.profile.update') }}" id="passwordForm">
                    @csrf
                    
                    <!-- Hidden fields to maintain other data -->
                    <input type="hidden" name="name" value="{{ $student->name }}">
                    <input type="hidden" name="phone" value="{{ $student->phone }}">
                    <input type="hidden" name="address" value="{{ $student->address }}">
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="current_password" class="form-label">Mật khẩu hiện tại *</label>
                            <input type="password" 
                                   class="form-control @error('current_password') is-invalid @enderror" 
                                   id="current_password" 
                                   name="current_password"
                                   placeholder="Nhập mật khẩu hiện tại">
                            @error('current_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="new_password" class="form-label">Mật khẩu mới *</label>
                            <input type="password" 
                                   class="form-control @error('new_password') is-invalid @enderror" 
                                   id="new_password" 
                                   name="new_password"
                                   placeholder="Nhập mật khẩu mới">
                            @error('new_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="new_password_confirmation" class="form-label">Xác nhận mật khẩu mới *</label>
                            <input type="password" 
                                   class="form-control" 
                                   id="new_password_confirmation" 
                                   name="new_password_confirmation"
                                   placeholder="Nhập lại mật khẩu mới">
                        </div>
                    </div>
                    
                    <div class="text-end">
                        <button type="button" class="btn btn-secondary me-2" onclick="clearPasswordForm()">
                            <i class="fas fa-times"></i> Hủy bỏ
                        </button>
                        <button type="submit" class="btn btn-warning">
                            <i class="fas fa-key"></i> Đổi mật khẩu
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Clear password form
    function clearPasswordForm() {
        document.getElementById('passwordForm').reset();
    }
    
    // Password strength indicator
    document.addEventListener('DOMContentLoaded', function() {
        const newPasswordInput = document.getElementById('new_password');
        const confirmPasswordInput = document.getElementById('new_password_confirmation');
        
        // Add password strength indicator
        newPasswordInput.addEventListener('input', function() {
            const password = this.value;
            const strength = checkPasswordStrength(password);
            
            // Remove existing feedback
            const existingFeedback = this.parentNode.querySelector('.password-strength');
            if (existingFeedback) {
                existingFeedback.remove();
            }
            
            if (password.length > 0) {
                const feedback = document.createElement('div');
                feedback.className = 'password-strength mt-1';
                feedback.innerHTML = `<small class="text-${strength.color}">Độ mạnh: ${strength.text}</small>`;
                this.parentNode.appendChild(feedback);
            }
        });
        
        // Check password confirmation match
        confirmPasswordInput.addEventListener('input', function() {
            const password = newPasswordInput.value;
            const confirmPassword = this.value;
            
            if (confirmPassword.length > 0) {
                if (password === confirmPassword) {
                    this.classList.remove('is-invalid');
                    this.classList.add('is-valid');
                } else {
                    this.classList.remove('is-valid');
                    this.classList.add('is-invalid');
                }
            } else {
                this.classList.remove('is-valid', 'is-invalid');
            }
        });
    });
    
    function checkPasswordStrength(password) {
        if (password.length < 6) {
            return { color: 'danger', text: 'Quá yếu (cần ít nhất 6 ký tự)' };
        } else if (password.length < 8) {
            return { color: 'warning', text: 'Trung bình' };
        } else if (password.match(/(?=.*[a-z])(?=.*[A-Z])(?=.*\d)/)) {
            return { color: 'success', text: 'Mạnh' };
        } else {
            return { color: 'info', text: 'Khá (thêm chữ hoa và số để mạnh hơn)' };
        }
    }
</script>
@endpush