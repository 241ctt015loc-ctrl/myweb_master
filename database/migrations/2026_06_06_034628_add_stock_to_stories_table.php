<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Chạy lệnh cập nhật database (Khi gõ php artisan migrate)
     */
    public function up(): void
    {
        Schema::table('stories', function (Blueprint $table) {
            // Tạo cột 'stock' kiểu số nguyên (Integer), giá trị mặc định ban đầu là 0
            // Thuộc tính ->after('price') giúp đặt cột này đứng ngay sau cột 'price' cho dễ nhìn
            $table->integer('stock')->default(0)->after('price');
        });
    }

    /**
     * Chạy lệnh hoàn tác hạ cấp database (Khi gõ php artisan migrate:rollback)
     */
    public function down(): void
    {
        Schema::table('stories', function (Blueprint $table) {
            // Nếu xóa migration này, hệ thống tự động gỡ bỏ cột stock khỏi database
            $table->dropColumn('stock');
        });
    }
};