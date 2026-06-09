<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập - Đệ Nhất Truyện</title>
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}?v={{ time() }}">
</head>
<body>

<div class="login-box">
    <h2>ĐĂNG NHẬP</h2>

    <form action="{{ route('login') }}" method="POST">
        @csrf 

        <input type="email" name="email" value="{{ old('email') }}" required placeholder="Email của bạn">
        
        <input type="password" name="password" required placeholder="Mật khẩu">

        @if ($errors->any())
            <div class="error">{{ $errors->first() }}</div>
        @endif

        <button type="submit">Đăng Nhập</button>
    </form>
    
    <p class="switch-text">
        Chưa có tài khoản? <a href="{{ route('register') }}">Đăng ký ngay</a>
    </p>
</div>

</body>
</html>