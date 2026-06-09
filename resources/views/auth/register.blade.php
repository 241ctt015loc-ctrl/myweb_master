<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký - Đệ Nhất Truyện</title>
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
</head>
<body>

<div class="login-box">
    <h2>ĐĂNG KÝ</h2>

    <form action="{{ route('register') }}" method="POST">
        @csrf 

        <input type="text" name="name" value="{{ old('name') }}" required placeholder="Họ và tên của bạn">
        
        <input type="email" name="email" value="{{ old('email') }}" required placeholder="Địa chỉ Email">
        
        <input type="password" name="password" required placeholder="Mật khẩu (ít nhất 6 ký tự)">
        
        <input type="password" name="password_confirmation" required placeholder="Nhập lại mật khẩu">

        @if ($errors->any())
            <div class="error">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </div>
        @endif

        <button type="submit">Đăng Ký Ngay</button>
    </form>
    
    <p class="switch-text">
        Đã có tài khoản? <a href="{{ route('login') }}">Đăng nhập</a>
    </p>
</div>

</body>
</html>