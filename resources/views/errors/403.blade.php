{{-- resources/views/errors/403.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>403 - Access Denied</title>
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body {
            background: #f1f5f9;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            font-family: 'Segoe UI', sans-serif;
        }
        .error-box {
            background: #fff;
            border-radius: 16px;
            padding: 48px 40px;
            text-align: center;
            max-width: 440px;
            width: 100%;
            box-shadow: 0 8px 24px rgba(0,0,0,.10);
        }
        .error-icon {
            width: 80px; height: 80px;
            background: #fef2f2;
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 20px;
            color: #ef4444; font-size: 32px;
        }
        .error-code { font-size: 56px; font-weight: 800; color: #ef4444; line-height: 1; }
        .error-title { font-size: 22px; font-weight: 700; color: #0f172a; margin: 8px 0; }
        .error-msg { color: #64748b; font-size: 14px; margin-bottom: 24px; }
    </style>
</head>
<body>
<div class="error-box">
    <div class="error-icon"><i class="fas fa-ban"></i></div>
    <div class="error-code">403</div>
    <div class="error-title">Access Denied</div>
    <p class="error-msg">
        You don't have permission to access this page.
        Please contact your administrator if you think this is a mistake.
    </p>
    <div class="d-flex gap-2 justify-content-center">
        <a href="{{ url()->previous() }}"
           class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-1"></i>Go Back
        </a>
        <a href="{{ route('dashboard') }}"
           class="btn btn-primary">
            <i class="fas fa-home me-1"></i>Dashboard
        </a>
    </div>
</div>
</body>
</html>
