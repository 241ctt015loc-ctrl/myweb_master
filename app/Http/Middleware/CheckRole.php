<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    public function handle(Request $request, Closure $next, $role)
    {
        // 1. Nếu chưa đăng nhập thì bắt đi đăng nhập
        if (!Auth::check()) {
            return redirect('login');
        }

        // 2. Nếu đã đăng nhập nhưng sai quyền (VD: Khách mà đòi vào trang Admin)
        if (Auth::user()->role !== $role) {
            return redirect('/')->with('error', 'Bạn không có quyền truy cập trang này!');
        }

        return $next($request);
    }
}