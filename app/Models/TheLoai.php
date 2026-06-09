<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class TheLoai extends Model {
    protected $table = 'categories'; 
    protected $fillable = ['TenTheLoai'];

    public function danhSachTruyen() {
        return $this->hasMany(Truyen::class, 'MaTheLoai', 'id');
    }
}