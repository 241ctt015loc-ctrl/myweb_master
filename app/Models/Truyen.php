<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Category;

class Truyen extends Model 
{
    protected $table = 'stories'; 

    protected $fillable = ['title', 'price', 'category_id', 'cover_image', 'summary', 'slug', 'stock'];
    function category()
    {
        // Sửa 'MaTheLoai' thành 'category_id' cho đúng với $fillable và bảng database
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

 
    public function getFormattedPriceAttribute() 
    {
        // Sửa $this->GiaBan thành $this->price
        return number_format($this->price, 0, ',', '.') . ' VNĐ';
    }

    /**
     * 3. Scope: Bộ lọc truyện còn hàng
     * Sử dụng: Truyen::conHang()->get();
     */
    public function scopeConHang($query) 
    {
        // Sửa 'SoLuongTon' thành 'stock' (Lưu ý: Bạn cần thêm cột 'stock' này vào migration/database nhé)
        return $query->where('stock', '>', 0);
    }
}