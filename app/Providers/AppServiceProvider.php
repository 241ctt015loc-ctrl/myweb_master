<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
public function boot()
{
    // Kiểm tra xem bảng categories có tồn tại không trước khi lấy dữ liệu
    if (\Schema::hasTable('categories')) {
        $categories = \DB::table('categories')->get();
        view()->share('categories', $categories);
    }
}
}
