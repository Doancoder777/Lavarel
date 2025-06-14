<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', '🎓 Student Management System')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{-- Auth Styles --}}
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: "Arial", sans-serif;
            overflow: hidden;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            position: relative;
        }
        .bg-animation {
            position: fixed; top: 0; left: 0; width: 100%; height: 100%; z-index: 1;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .bg-animation::before {
            content: "";
            position: absolute; top: 0; left: 0; width: 100%; height: 100%;
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.1'%3E%3Ccircle cx='30' cy='30' r='4'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
            animation: float 20s ease-in-out infinite;
        }
        @keyframes float {
            0%, 100% { transform: translate(0, 0) rotate(0deg); }
            33% { transform: translate(30px, -30px) rotate(120deg); }
            66% { transform: translate(-20px, 20px) rotate(240deg); }
        }
        .floating-shapes { position: fixed; top: 0; left: 0; width: 100%; height: 100%; z-index: 2; pointer-events: none; }
        .shape { position: absolute; background: rgba(255, 255, 255, 0.1); border-radius: 50%; animation: floatUp 6s ease-in-out infinite; }
        .shape:nth-child(1) { width: 80px; height: 80px; top: 70%; left: 10%; animation-delay: 0s; }
        .shape:nth-child(2) { width: 60px; height: 60px; top: 20%; right: 10%; animation-delay: 2s; }
        .shape:nth-child(3) { width: 40px; height: 40px; top: 80%; right: 20%; animation-delay: 4s; }
        @keyframes floatUp {
            0%, 100% { transform: translateY(0) rotate(0deg); opacity: 0.7; }
            50% { transform: translateY(-20px) rotate(180deg); opacity: 1; }
        }
        .auth-container {
            position: relative; z-index: 10;
            display: flex; justify-content: center; align-items: center;
            min-height: 100vh; padding: 20px;
        }
        .auth-box {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.3);
            width: 100%; max-width: 450px;
            opacity: 0; transform: translateY(30px);
            animation: slideIn 1s ease-out 0.3s forwards;
        }
        @keyframes slideIn { to { opacity: 1; transform: translateY(0); } }
        .auth-header { text-align: center; margin-bottom: 35px; }
        .auth-title {
            color: white; font-size: 2.8rem; font-weight: bold; margin-bottom: 10px;
            opacity: 0; animation: fadeInUp 1s ease-out 0.8s forwards;
            text-shadow: 0 2px 4px rgba(0,0,0,0.3);
        }
        .auth-subtitle {
            color: rgba(255, 255, 255, 0.9); font-size: 1.1rem;
            opacity: 0; animation: fadeInUp 1s ease-out 1s forwards;
        }
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .form-group { margin-bottom: 25px; opacity: 0; animation: fadeInUp 1s ease-out forwards; position: relative; }
        .form-group:nth-child(1) { animation-delay: 1.2s; }
        .form-group:nth-child(2) { animation-delay: 1.4s; }
        .form-group:nth-child(3) { animation-delay: 1.6s; }
        .form-group:nth-child(4) { animation-delay: 1.8s; }
        .form-input {
            width: 100%; padding: 18px 25px; border: none; border-radius: 15px;
            background: rgba(255, 255, 255, 0.2); color: white; font-size: 1rem;
            border: 2px solid transparent; transition: all 0.3s ease; backdrop-filter: blur(10px);
        }
        .form-input::placeholder { color: rgba(255, 255, 255, 0.8); }
        .form-input:focus {
            outline: none; border-color: rgba(255, 255, 255, 0.6);
            background: rgba(255, 255, 255, 0.3); transform: translateY(-2px);
            box-shadow: 0 15px 25px rgba(0, 0, 0, 0.1);
        }
        .btn-primary {
            width: 100%; padding: 18px; border: none; border-radius: 15px;
            background: linear-gradient(45deg, #ff6b6b, #feca57); color: white;
            font-size: 1.2rem; font-weight: bold; cursor: pointer; transition: all 0.3s ease;
            position: relative; overflow: hidden; text-transform: uppercase; letter-spacing: 1px;
        }
        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 20px 40px rgba(255, 107, 107, 0.4);
            background: linear-gradient(45deg, #ff5252, #ffc107);
        }
        .btn-secondary {
            background: linear-gradient(45deg, #28a745, #20c997); color: white;
            border: none; padding: 8px 16px; border-radius: 20px; font-size: 0.85rem;
            cursor: pointer; transition: all 0.3s ease; text-transform: uppercase;
            font-weight: bold; letter-spacing: 0.5px;
        }
        .btn-secondary:hover {
            background: linear-gradient(45deg, #218838, #1ba085);
            transform: scale(1.05);
            box-shadow: 0 5px 15px rgba(40, 167, 69, 0.4);
        }
        .alert {
            padding: 15px; margin-bottom: 20px; border-radius: 10px;
            opacity: 0; animation: fadeInUp 1s ease-out 2.2s forwards;
        }
        .alert-danger {
            background: rgba(220, 53, 69, 0.2);
            border: 1px solid rgba(220, 53, 69, 0.3);
            color: #fff;
        }
        .alert-success {
            background: rgba(40, 167, 69, 0.2);
            border: 1px solid rgba(40, 167, 69, 0.3);
            color: #fff;
        }
        .alert-info {
            background: rgba(23, 162, 184, 0.2);
            border: 1px solid rgba(23, 162, 184, 0.3);
            color: #fff;
        }
        @media (max-width: 768px) {
            .auth-box { margin: 20px; padding: 30px; }
            .auth-title { font-size: 2.2rem; }
        }
        @yield('styles')
    </style>
    @stack('styles')
</head>
<body>
    <div class="bg-animation"></div>
    <div class="floating-shapes">
        <div class="shape"></div>
        <div class="shape"></div>
        <div class="shape"></div>
    </div>
    <div class="auth-container">
        <div class="auth-box">
            @yield('content')
        </div>
    </div>
    <script>
        document.addEventListener("click", function(e) {
            if (e.target.classList.contains("btn-primary") || e.target.classList.contains("btn-secondary")) {
                const button = e.target;
                const ripple = document.createElement("span");
                const rect = button.getBoundingClientRect();
                const size = Math.max(rect.width, rect.height);
                const x = e.clientX - rect.left - size / 2;
                const y = e.clientY - rect.top - size / 2;
                ripple.style.width = ripple.style.height = size + "px";
                ripple.style.left = x + "px";
                ripple.style.top = y + "px";
                ripple.style.position = "absolute";
                ripple.style.borderRadius = "50%";
                ripple.style.transform = "scale(0)";
                ripple.style.animation = "ripple 0.6s linear";
                ripple.style.backgroundColor = "rgba(255, 255, 255, 0.7)";
                if (!document.querySelector('#ripple-style')) {
                    const style = document.createElement('style');
                    style.id = 'ripple-style';
                    style.textContent = `
                        @keyframes ripple {
                            to {
                                transform: scale(4);
                                opacity: 0;
                            }
                        }
                    `;
                    document.head.appendChild(style);
                }
                button.appendChild(ripple);
                setTimeout(() => { ripple.remove(); }, 600);
            }
        });
        document.addEventListener('DOMContentLoaded', function() {
            const firstInput = document.querySelector('.form-input');
            if (firstInput) {
                setTimeout(() => firstInput.focus(), 1000);
            }
            const forms = document.querySelectorAll('form');
            forms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    const submitBtn = form.querySelector('[type="submit"]');
                    if (submitBtn) {
                        submitBtn.disabled = true;
                        submitBtn.innerHTML = '⏳ Processing...';
                        setTimeout(() => {
                            submitBtn.disabled = false;
                            submitBtn.innerHTML = submitBtn.dataset.originalText || 'Submit';
                        }, 3000);
                    }
                });
            });
        });
    </script>
    @stack('scripts')
</body>
</html>
