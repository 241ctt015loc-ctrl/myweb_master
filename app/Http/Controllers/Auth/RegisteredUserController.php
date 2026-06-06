<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Hiển thị trang đăng ký.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Xử lý yêu cầu đăng ký tài khoản mới.
     */
    public function store(Request $request): RedirectResponse
    {
        // 1. Kiểm tra dữ liệu đầu vào
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // 2. Tạo người dùng mới với role mặc định là customer
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'customer', // Gán quyền khách hàng tại đây
        ]);

        // 3. Kích hoạt sự kiện đã đăng ký
        event(new Registered($user));

        // 4. Tự động đăng nhập sau khi tạo tài khoản
        Auth::login($user);

        // 5. Chuyển hướng về trang chủ (/) để tránh lỗi Route [dashboard] not defined
        return redirect('/');
    }
}