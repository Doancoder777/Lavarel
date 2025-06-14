<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    /**
     * Show login form
     */
    public function showLogin()
    {
        // Nếu đã đăng nhập, chuyển hướng về dashboard phù hợp
        if (Auth::check()) {
            return $this->redirectBasedOnRole();
        }
        // Trả về view Blade
        return view('auth.login');
    }

    /**
     * Handle login request
     */
    public function login(Request $request)
    {
        // Ghi log thử đăng nhập
        Log::info('Login attempt received', [
            'email' => $request->email,
            'has_password' => !empty($request->password),
            'ip' => $request->ip(),
        ]);

        // Validate dữ liệu
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:3',
        ], [
            'email.required' => 'Email không được để trống',
            'email.email' => 'Email không đúng định dạng',
            'password.required' => 'Mật khẩu không được để trống',
            'password.min' => 'Mật khẩu phải có ít nhất 3 ký tự',
        ]);

        // Thử đăng nhập
        $credentials = [
            'email' => $request->email,
            'password' => $request->password
        ];
        $remember = $request->has('remember');

        if (Auth::attempt($credentials, $remember)) {
            $user = Auth::user();

            Log::info('Login successful', [
                'user_id' => $user->id,
                'email' => $user->email,
                'role' => $user->role
            ]);

            // Regenerate session để bảo mật
            $request->session()->regenerate();

            // Chuyển hướng dựa vào role
            return $this->redirectBasedOnRole()
                ->with('success', 'Đăng nhập thành công! Chào mừng ' . $user->name);
        }

        // Đăng nhập thất bại
        Log::warning('Login failed', [
            'email' => $request->email,
            'ip' => $request->ip()
        ]);

        // Quay lại với lỗi
        return back()
            ->withInput($request->only('email', 'remember'))
            ->withErrors(['email' => 'Email hoặc mật khẩu không chính xác']);
    }

    /**
     * Handle logout request
     */
    public function logout(Request $request)
    {
        $userName = Auth::user()->name ?? 'User';

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')
            ->with('success', 'Đăng xuất thành công! Hẹn gặp lại ' . $userName);
    }

    /**
     * Redirect user based on their role
     */
    private function redirectBasedOnRole()
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        } elseif ($user->role === 'student') {
            return redirect()->route('student.dashboard');
        }

        return redirect()->route('login');
    }
}
