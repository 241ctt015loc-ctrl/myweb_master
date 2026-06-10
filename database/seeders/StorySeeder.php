<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; 

class StorySeeder extends Seeder
{
   
    public function run(): void
    {
   
        $catId = DB::table('categories')->insertGetId([
            'name' => 'Tiên Hiệp',
            'slug' => 'tien-hiep',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

      
        DB::table('stories')->insert([
            'title' => 'Đệ Nhất Kiếm Thần',
            'slug' => 'de-nhat-kiem-than',
            'price' => 50000,
            'category_id' => $catId,
            'summary' => 'Một thanh kiếm, một thế giới...',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}