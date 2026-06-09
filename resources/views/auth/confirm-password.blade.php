<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xác nhận mật khẩu - Đệ Nhất Truyện</title>
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}?v={{ time() }}">
    <style>
        .secure-text {
            color: #aaa;
            font-size: 14px;
            line-height: 1.6;
            margin-bottom: 25px;
            text-align: left;
            border-left: 3px solid #ff2d20;
            padding-left: 10px;
        }
    </style>
</head>
<body>

<div class="login-box">
    <h2>XÁC NHẬN MẬT KHẨU</h2>

    <p class="secure-text">
        Đây là khu vực bảo mật tối cao của hệ thống. Vui lòng nhập lại mật khẩu của bạn để xác minh danh tính trước khi tiếp tục.
    </p>

    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf

        <input type="password" name="password" required autocomplete="current-password" autofocus placeholder="Nhập mật khẩu của bạn">

        @if ($errors->any())
            <div class="error">
                {{ $errors->first() }}
            </div>
        @endif

        <button type="submit">Xác nhận</button>
    </form>
</div>

</body>
</html>