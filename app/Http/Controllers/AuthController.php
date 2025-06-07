<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use App\Models\User;

class AuthController extends Controller
{
    /**
     * Show login form
     */
    public function showLogin()
    {
        // If user is already logged in, redirect to dashboard
        if (Auth::check()) {
            return $this->redirectBasedOnRole();
        }

        // Return simple HTML form
        $html = '
        <!DOCTYPE html>
        <html>
        <head>
            <title>Login - Student Management</title>
            <style>
                body { font-family: Arial; padding: 50px; background: #f5f5f5; }
                .login-box { max-width: 400px; margin: 0 auto; background: white; padding: 30px; border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
                input { width: 100%; padding: 10px; margin: 10px 0; border: 1px solid #ddd; border-radius: 5px; box-sizing: border-box; }
                button { width: 100%; padding: 15px; background: #007bff; color: white; border: none; border-radius: 5px; cursor: pointer; font-size: 16px; }
                button:hover { background: #0056b3; }
                .error { color: red; margin: 10px 0; }
                .success { color: green; margin: 10px 0; }
                .test-accounts { background: #f8f9fa; padding: 15px; margin: 20px 0; border-radius: 5px; }
                h2 { text-align: center; color: #333; }
                .quick-fill { display: inline-block; margin-left: 10px; padding: 5px 10px; background: #28a745; color: white; text-decoration: none; border-radius: 3px; font-size: 12px; cursor: pointer; }
            </style>
        </head>
        <body>
            <div class="login-box">
                <h2>🎓 Đăng nhập hệ thống</h2>
                
                <form method="POST" action="/login" id="loginForm">
                    <input type="hidden" name="_token" value="' . csrf_token() . '">
                    
                    <input type="email" id="email" name="email" placeholder="Email" required autofocus>
                    
                    <input type="password" id="password" name="password" placeholder="Mật khẩu" required>
                    
                    <label style="margin: 10px 0; display: block;">
                        <input type="checkbox" name="remember"> Ghi nhớ đăng nhập
                    </label>
                    
                    <button type="submit" onclick="handleSubmit(event)">Đăng nhập</button>
                </form>

                <div class="test-accounts">
                    <h4>Tài khoản test:</h4>
                    <p><strong>Admin:</strong> admin@school.edu.vn / admin123 
                       <span class="quick-fill" onclick="fillAdmin()">Điền nhanh</span>
                    </p>
                    <p><strong>Student:</strong> an@student.edu.vn / 123456
                       <span class="quick-fill" onclick="fillStudent()">Điền nhanh</span>
                    </p>
                </div>
                
                <div id="debug" style="margin-top: 20px; font-size: 12px; color: #666;"></div>
            </div>
            
            <script>
                function fillAdmin() {
                    document.getElementById("email").value = "admin@school.edu.vn";
                    document.getElementById("password").value = "admin123";
                }
                
                function fillStudent() {
                    document.getElementById("email").value = "an@student.edu.vn";
                    document.getElementById("password").value = "123456";
                }
                
                function handleSubmit(event) {
                    const form = document.getElementById("loginForm");
                    const debug = document.getElementById("debug");
                    
                    debug.innerHTML = "Form submitting...";
                    
                    // Let form submit normally
                    return true;
                }
                
                // Debug info
                document.addEventListener("DOMContentLoaded", function() {
                    const debug = document.getElementById("debug");
                    debug.innerHTML = "Form action: " + document.getElementById("loginForm").action + "<br>CSRF token: " + document.querySelector("input[name=_token]").value.substring(0, 10) + "...";
                });
            </script>
        </body>
        </html>';

        return response($html);
    }

    /**
     * Handle login request
     */
    public function login(Request $request)
    {
        // Debug log
        Log::info('Login attempt received', [
            'email' => $request->email,
            'has_password' => !empty($request->password),
            'ip' => $request->ip(),
            'all_data' => $request->all()
        ]);

        // Simple validation
        if (!$request->email || !$request->password) {
            return response('
            <h2>Lỗi</h2>
            <p>Email và mật khẩu không được để trống</p>
            <a href="/login">Quay lại</a>
            ');
        }

        // Attempt authentication
        $credentials = [
            'email' => $request->email,
            'password' => $request->password
        ];

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            
            Log::info('Login successful', [
                'user_id' => $user->id,
                'email' => $user->email,
                'role' => $user->role
            ]);

            // Return success page with redirect
            return response('
            <!DOCTYPE html>
            <html>
            <head>
                <title>Đăng nhập thành công</title>
                <meta http-equiv="refresh" content="2;url=' . ($user->role === 'admin' ? '/admin/dashboard' : '/student/dashboard') . '">
            </head>
            <body style="font-family: Arial; padding: 50px; text-align: center;">
                <h2>✅ Đăng nhập thành công!</h2>
                <p>Chào mừng <strong>' . $user->name . '</strong></p>
                <p>Đang chuyển hướng...</p>
                <p><a href="' . ($user->role === 'admin' ? '/admin/dashboard' : '/student/dashboard') . '">Click để tiếp tục</a></p>
            </body>
            </html>
            ');
        }

        // Login failed
        Log::warning('Login failed', [
            'email' => $request->email,
            'ip' => $request->ip()
        ]);

        return response('
        <!DOCTYPE html>
        <html>
        <head><title>Đăng nhập thất bại</title></head>
        <body style="font-family: Arial; padding: 50px; text-align: center;">
            <h2>❌ Đăng nhập thất bại</h2>
            <p>Email hoặc mật khẩu không chính xác</p>
            <a href="/login">Thử lại</a>
        </body>
        </html>
        ');
    }

    /**
     * Handle logout request
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('success', 'Đăng xuất thành công!');
    }

    /**
     * Redirect user based on their role
     */
    private function redirectBasedOnRole()
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            return redirect('/admin/dashboard');
        } elseif ($user->role === 'student') {
            return redirect('/student/dashboard');
        }

        return redirect('/login');
    }
}