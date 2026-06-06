<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GioHangController; 
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TruyenAdminController;

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


// ==========================================
// PHẦN 2: KHU VỰC BẮT BUỘC ĐĂNG NHẬP (AUTH)
// ==========================================
Route::middleware('auth')->group(function () {
    
    /**
     * TRANG DASHBOARD CHUNG (Tách riêng khỏi nhóm admin)
     * Tên đầy đủ hệ thống nhận diện: 'dashboard' -> Sửa triệt để lỗi RouteNotFoundException
     */
    Route::get('/dashboard', function() {
        return view('dashboard'); // Trả về view dashboard mặc định của Breeze
    })->name('dashboard');

    // 1. DÀNH CHO KHÁCH HÀNG (Hoặc người dùng đã đăng nhập chung)
    Route::get('/thanh-toan', [GioHangController::class, 'thanhToan'])->name('cart.checkout');
    Route::post('/xu-ly-thanh-toan', [GioHangController::class, 'xuLyThanhToan'])->name('cart.process');
    
    // Cập nhật Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // 2. DÀNH CHO QUẢN LÝ (ADMIN)
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        // Trang tổng quan nội bộ riêng của Admin (Tên: admin.overview)
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

    // 3. DÀNH CHO NHÂN VIÊN (STAFF)
    Route::middleware('role:staff')->prefix('staff')->name('staff.')->group(function () {
        Route::get('/don-hang', function() {
            return "Đây là trang duyệt đơn hàng cho Nhân viên";
        })->name('orders');
    });

    // 4. DÀNH CHO SHIPPER
    Route::middleware('role:shipper')->prefix('shipper')->name('shipper.')->group(function () {
        Route::get('/giao-hang', function() {
            return "Đây là trang nhận đơn đi giao của Shipper";
        })->name('deliveries');
    });

}); // Kết thúc nhóm Route::middleware('auth')


// File auth.php của Laravel Breeze 
require __DIR__.'/auth.php';