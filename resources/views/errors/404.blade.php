{{-- resources/views/errors/404.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Page Not Found</title>
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 20px;
        }

        .error-wrapper {
            text-align: center;
            max-width: 520px;
            width: 100%;
        }

        .error-animation {
            position: relative;
            margin-bottom: 32px;
        }

        .error-code {
            font-size: clamp(80px, 20vw, 140px);
            font-weight: 900;
            line-height: 1;
            background: linear-gradient(135deg, #3b82f6, #8b5cf6);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            letter-spacing: -4px;
            user-select: none;
        }

        .error-icon-float {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 70px;
            height: 70px;
            background: #fff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 8px 24px rgba(59, 130, 246, 0.3);
            animation: float 3s ease-in-out infinite;
        }

        .error-icon-float i {
            font-size: 28px;
            color: #3b82f6;
        }

        @keyframes float {
            0%, 100% { transform: translate(-50%, -50%) translateY(0px); }
            50%       { transform: translate(-50%, -50%) translateY(-10px); }
        }

        .error-box {
            background: #ffffff;
            border-radius: 20px;
            padding: 40px 36px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.10);
            border: 1px solid #e2e8f0;
        }

        .error-title {
            font-size: 26px;
            font-weight: 800;
            color: #0f172a;
            margin-bottom: 10px;
        }

        .error-message {
            color: #64748b;
            font-size: 15px;
            line-height: 1.6;
            margin-bottom: 28px;
        }

        .error-actions {
            display: flex;
            gap: 10px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .btn-home {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 11px 24px;
            background: linear-gradient(135deg, #3b82f6, #2563eb);
            color: #fff;
            border: none;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.2s;
            cursor: pointer;
        }

        .btn-home:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(59, 130, 246, 0.4);
            color: #fff;
        }

        .btn-back {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 11px 24px;
            background: transparent;
            color: #64748b;
            border: 1.5px solid #e2e8f0;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.2s;
            cursor: pointer;
        }

        .btn-back:hover {
            border-color: #3b82f6;
            color: #3b82f6;
            background: #eff6ff;
        }

        .error-divider {
            height: 1px;
            background: #f1f5f9;
            margin: 24px 0;
        }

        .error-suggestions {
            text-align: left;
        }

        .error-suggestions-title {
            font-size: 13px;
            font-weight: 700;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 12px;
        }

        .suggestion-link {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 14px;
            border-radius: 8px;
            text-decoration: none;
            color: #334155;
            font-size: 13.5px;
            transition: all 0.2s;
            margin-bottom: 4px;
        }

        .suggestion-link:hover {
            background: #f1f5f9;
            color: #3b82f6;
        }

        .suggestion-link i {
            width: 30px;
            height: 30px;
            background: #f1f5f9;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            color: #3b82f6;
            flex-shrink: 0;
            transition: all 0.2s;
        }

        .suggestion-link:hover i {
            background: #dbeafe;
        }

        .error-footer {
            margin-top: 24px;
            font-size: 12px;
            color: #94a3b8;
        }
    </style>
</head>
<body>
    <div class="error-wrapper">

        {{-- Animated Number --}}
        <div class="error-animation">
            <div class="error-code">404</div>
            <div class="error-icon-float">
                <i class="fas fa-search"></i>
            </div>
        </div>

        {{-- Error Box --}}
        <div class="error-box">
            <h1 class="error-title">Page Not Found</h1>
            <p class="error-message">
                The page you are looking for doesn't exist or has been moved.
                Please check the URL or navigate using the links below.
            </p>

            <div class="error-actions">
                <a href="{{ url('/') }}" class="btn-home">
                    <i class="fas fa-home"></i>
                    Go to Dashboard
                </a>
                <a href="javascript:history.back()" class="btn-back">
                    <i class="fas fa-arrow-left"></i>
                    Go Back
                </a>
            </div>

            <div class="error-divider"></div>

            {{-- Quick Links --}}
            <div class="error-suggestions">
                <div class="error-suggestions-title">
                    <i class="fas fa-compass me-1"></i> Quick Navigation
                </div>

                @auth
                <a href="{{ route('dashboard') }}" class="suggestion-link">
                    <i class="fas fa-tachometer-alt"></i>
                    Dashboard
                </a>
                <a href="{{ route('admin.assets.index') }}" class="suggestion-link">
                    <i class="fas fa-boxes-stacked"></i>
                    All Assets
                </a>
                <a href="{{ route('admin.departments.index') }}" class="suggestion-link">
                    <i class="fas fa-building"></i>
                    Departments
                </a>
                <a href="{{ route('admin.employees.index') }}" class="suggestion-link">
                    <i class="fas fa-users"></i>
                    Employees
                </a>
                @else
                <a href="{{ route('login') }}" class="suggestion-link">
                    <i class="fas fa-sign-in-alt"></i>
                    Login to System
                </a>
                @endauth
            </div>
        </div>

        <div class="error-footer">
            &copy; {{ date('Y') }} Government Asset Management System
        </div>
    </div>
</body>
</html>
