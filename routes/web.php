<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GioHangController; // Code của bạn
use App\Http\Controllers\AuthController;    // Code của bạn bạn
use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ==========================================
// PHẦN 1: TÍNH NĂNG CHÍNH (DO BẠN VIẾT)
// ==========================================

// 1. TRANG CHỦ (Hiển thị danh sách truyện)
Route::get('/', [GioHangController::class, 'index'])->name('home');

// 2. TÌM KIẾM TRUYỆN
Route::get('/search', [GioHangController::class, 'search'])->name('search');

// 3. XEM CHI TIẾT TRUYỆN (Trang chọn tập/chap)
Route::get('/truyen/{id}', [GioHangController::class, 'show'])->name('story.show');

// 4. GIỎ HÀNG
Route::get('/gio-hang', [GioHangController::class, 'xemGioHang'])->name('cart.index');
Route::post('/mua-hang/{id}', [GioHangController::class, 'themVaoGio'])->name('cart.add');
Route::get('/xoa-khoi-gio/{id}', [GioHangController::class, 'xoaKhoiGio'])->name('cart.remove');
Route::get('/reset-gio-hang', function() {
    session()->forget('gio_hang');
    return redirect()->route('home')->with('swal_success', 'Đã dọn dẹp giỏ hàng!');
});

// 5. THANH TOÁN
Route::get('/thanh-toan', [GioHangController::class, 'thanhToan'])->name('cart.checkout');
Route::post('/xu-ly-thanh-toan', [GioHangController::class, 'xuLyThanhToan'])->name('cart.process');

// 6. LỌC THEO THỂ LOẠI
Route::get('/the-loai/{slug}', [GioHangController::class, 'theLoai'])->name('category.show');


// ==========================================
// PHẦN 2: TÍNH NĂNG ĐĂNG NHẬP (CỦA BẠN BẠN VIẾT)
// ==========================================
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


// ==========================================
// PHẦN 3: BREEZE ĐỂ DỰ PHÒNG (NẾU CẦN)
// ==========================================
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
// Route lọc truyện theo thể loại
Route::get('/the-loai/{id}', [App\Http\Controllers\GioHangController::class, 'theLoai'])->name('category.show');