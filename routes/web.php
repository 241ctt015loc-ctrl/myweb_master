<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GioHangController; 

use App\Http\Controllers\TruyenAdminController;
use App\Http\Controllers\AuthController;

Route::get('/', [GioHangController::class, 'index'])->name('home');
Route::get('/search', [GioHangController::class, 'search'])->name('search');
Route::get('/truyen/{id}', [GioHangController::class, 'show'])->name('story.show');
Route::get('/the-loai/{id}', [GioHangController::class, 'theLoai'])->name('category.show');

Route::get('/gio-hang', [GioHangController::class, 'xemGioHang'])->name('cart.index');
Route::post('/mua-hang/{id}', [GioHangController::class, 'themVaoGio'])->name('cart.add');
Route::get('/xoa-khoi-gio/{id}', [GioHangController::class, 'xoaKhoiGio'])->name('cart.remove');
Route::get('/reset-gio-hang', function() {
    session()->forget('gio_hang');
    return redirect()->route('home')->with('swal_success', 'Đã dọn dẹp giỏ hàng!');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::middleware('auth')->group(function () {
    
    Route::get('/dashboard', function() {
        return redirect('/'); 
    })->name('dashboard');

    Route::get('/thanh-toan', [GioHangController::class, 'thanhToan'])->name('cart.checkout');
    Route::post('/xu-ly-thanh-toan', [GioHangController::class, 'xuLyThanhToan'])->name('cart.process');
    

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {

        Route::get('/overview', function() {
            return "Đây là trang quản trị của Admin";
        })->name('overview');
        
        Route::get('/truyen',           [TruyenAdminController::class, 'index'])->name('truyen.index');
        Route::get('/truyen/them',      [TruyenAdminController::class, 'create'])->name('truyen.create');
        Route::post('/truyen',          [TruyenAdminController::class, 'store'])->name('truyen.store');
        Route::get('/truyen/{id}/sua',  [TruyenAdminController::class, 'edit'])->name('truyen.edit');
        Route::put('/truyen/{id}',      [TruyenAdminController::class, 'update'])->name('truyen.update');
        Route::delete('/truyen/{id}',   [TruyenAdminController::class, 'destroy'])->name('truyen.destroy');
    }); 

}); 