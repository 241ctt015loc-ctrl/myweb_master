<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User; 
use Illuminate\Support\Facades\Hash; 

class AuthController extends Controller
{
    // --- PHẦN ĐĂNG NHẬP ---
    public function showLogin() {
        return view('auth.login');
    }

    public function login(Request $request) {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/');
        }

        return back()->withErrors(['email' => 'Email hoặc mật khẩu không đúng.']);
    }

    // --- PHẦN ĐĂNG KÝ ---
    public function showRegister() {
       
        return view('auth.register'); 
    }

    public function register(Request $request) {
        // 1. Kiểm tra dữ liệu người dùng nhập vào
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed', 
        ], [
            'email.unique' => 'Email này đã được sử dụng.',
            'password.confirmed' => 'Mật khẩu nhập lại không khớp.',
            'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự.'
        ]);

        // 2. Tạo tài khoản mới
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), 
        ]);

        // 3. Đăng nhập luôn sau khi đăng ký xong
        Auth::login($user);

        // 4. Chuyển về trang chủ kèm thông báo thành công
        return redirect('/')->with('success', 'Đăng ký tài khoản thành công!');
    }

    // --- PHẦN ĐĂNG XUẤT ---
    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}