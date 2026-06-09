<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GioHangController; 
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TruyenAdminController;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ==========================================
// PHẦN 1: TÍNH NĂNG CHÍNH (AI CŨNG XEM ĐƯỢC)
// ==========================================
Route::get('/', [GioHangController::class, 'index'])->name('home');
Route::get('/search', [GioHangController::class, 'search'])->name('search');
Route::get('/truyen/{id}', [GioHangController::class, 'show'])->name('story.show');
Route::get('/the-loai/{id}', [GioHangController::class, 'theLoai'])->name('category.show');

// GIỎ HÀNG (Chưa đăng nhập vẫn xem được giỏ hàng)
Route::get('/gio-hang', [GioHangController::class, 'xemGioHang'])->name('cart.index');
Route::post('/mua-hang/{id}', [GioHangController::class, 'themVaoGio'])->name('cart.add');
Route::get('/xoa-khoi-gio/{id}', [GioHangController::class, 'xoaKhoiGio'])->name('cart.remove');
Route::get('/reset-gio-hang', function() {
    session()->forget('gio_hang');
    return redirect()->route('home')->with('swal_success', 'Đã dọn dẹp giỏ hàng!');
});

// CÁC TRANG GIAO DIỆN VÀ XỬ LÝ ĐĂNG KÝ / ĐĂNG NHẬP (Sử dụng AuthController của bạn)
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);


// ==========================================
// PHẦN 2: KHU VỰC BẮT BUỘC ĐĂNG NHẬP (AUTH)
// ==========================================
Route::middleware('auth')->group(function () {
    
    // Nếu Breeze tự động đá về /dashboard, lệnh này sẽ đẩy user ngược về trang chủ ngay lập tức
    Route::get('/dashboard', function() {
        return redirect('/'); 
    })->name('dashboard');

    // Thanh toán đơn hàng
    Route::get('/thanh-toan', [GioHangController::class, 'thanhToan'])->name('cart.checkout');
    Route::post('/xu-ly-thanh-toan', [GioHangController::class, 'xuLyThanhToan'])->name('cart.process');
    
    // Quản lý thông tin cá nhân
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Trang xử lý Đăng xuất
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // KHU VỰC DÀNH RIÊNG CHO ADMIN (Kiểm tra quyền role:admin)
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        // Trang tổng quan nội bộ riêng của Admin
        Route::get('/overview', function() {
            return "Đây là trang quản trị của Admin";
        })->name('overview');
        
        // Quản lý truyện
        Route::get('/truyen',           [TruyenAdminController::class, 'index'])->name('truyen.index');
        Route::get('/truyen/them',      [TruyenAdminController::class, 'create'])->name('truyen.create');
        Route::post('/truyen',          [TruyenAdminController::class, 'store'])->name('truyen.store');
        Route::get('/truyen/{id}/sua',  [TruyenAdminController::class, 'edit'])->name('truyen.edit');
        Route::put('/truyen/{id}',      [TruyenAdminController::class, 'update'])->name('truyen.update');
        Route::delete('/truyen/{id}',   [TruyenAdminController::class, 'destroy'])->name('truyen.destroy');
    }); 

}); // Đóng ngoặc chuẩn xác cho nhóm Route::middleware('auth')