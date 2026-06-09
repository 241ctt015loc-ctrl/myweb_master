<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quên mật khẩu - Đệ Nhất Truyện</title>
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}?v={{ time() }}">
    <style>
       
        .description {
            color: #aaa;
            font-size: 14px;
            line-height: 1.6;
            margin-bottom: 20px;
            text-align: left;
        }
      
        .status-success {
            background-color: rgba(40, 167, 69, 0.1);
            border-left: 4px solid #28a745;
            color: #28a745;
            font-size: 14px;
            padding: 12px;
            border-radius: 6px;
            text-align: left;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>

<div class="login-box">
    <h2>QUÊN MẬT KHẨU</h2>

    <p class="description">
        Bạn quên mật khẩu? Không sao cả. Hãy nhập địa chỉ email đã đăng ký, chúng tôi sẽ gửi cho bạn một liên kết để tạo lại mật khẩu mới.
    </p>

    @if (session('status'))
        <div class="status-success">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <input type="email" name="email" value="{{ old('email') }}" required autofocus placeholder="Nhập email của bạn">

        @if ($errors->any())
            <div class="error">
                {{ $errors->first() }}
            </div>
        @endif

        <button type="submit">Gửi liên kết đặt lại mật khẩu</button>
    </form>

    <p class="switch-text">
        <a href="{{ route('login') }}" style="color: #888; font-weight: normal;">← Quay lại đăng nhập</a>
    </p>
</div>

</body>
</html>