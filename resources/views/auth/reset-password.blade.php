<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đặt lại mật khẩu - Đệ Nhất Truyện</title>
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}?v={{ time() }}">
</head>
<body>

<div class="login-box">
    <h2>ĐẶT LẠI MẬT KHẨU</h2>

    <form method="POST" action="{{ route('password.store') }}">
        @csrf

        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <input type="email" name="email" value="{{ old('email', $request->email) }}" required autofocus placeholder="Email của bạn">

        <input type="password" name="password" required placeholder="Mật khẩu mới">

        <input type="password" name="password_confirmation" required placeholder="Nhập lại mật khẩu mới">

        @if ($errors->any())
            <div class="error">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </div>
        @endif

        <button type="submit">Cập nhật mật khẩu</button>
    </form>
</div>

</body>
</html>