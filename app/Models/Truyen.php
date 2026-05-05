<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Truyen extends Model {
    protected $table = 'truyens'; // Giữ link với bảng migrations tiếng Anh để khỏi lỗi db
    protected $fillable = ['MaTheLoai', 'TenTruyen', 'GiaBan', 'SoLuongTon', 'HinhAnh'];

    // 1. Quan hệ
    public function theLoai() {
        return $this->belongsTo(TheLoai::class, 'MaTheLoai', 'id');
    }

    // 2. Tự động đẹp hóa giá tiền (Ví dụ: 50000 -> 50.000 VNĐ)
    public function getGiaVndAttribute() {
        return number_format($this->GiaBan, 0, ',', '.') . ' VNĐ';
    }

    // 3. Bộ lọc truyện còn hàng
    public function scopeConHang($query) {
        return $query->where('SoLuongTon', '>', 0);
    }
    public function category()
{
    // Liên kết: Một cuốn truyện thuộc về một thể loại
    return $this->belongsTo(Category::class, 'MaTheLoai', 'id');
}
}