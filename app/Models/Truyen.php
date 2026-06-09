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
        
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

 
    public function getFormattedPriceAttribute() 
    {
        
        return number_format($this->price, 0, ',', '.') . ' VNĐ';
    }

    public function scopeConHang($query) 
    {
        
    }
}