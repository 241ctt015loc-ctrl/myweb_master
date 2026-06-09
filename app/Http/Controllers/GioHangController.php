<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Truyen; 

class GioHangController extends Controller
{
    /**
     * 1. Hàm hiển thị TRANG CHỦ
     */
    public function index(Request $request)
    {
        $query = $request->input('query');
        $storiesQuery = \App\Models\Truyen::query();

        if ($query) {
            $storiesQuery->where('title', 'LIKE', "%{$query}%");
        }

        $stories = $storiesQuery->get();
        
        $categories = \DB::table('categories')->get();

        return view('welcome', compact('stories', 'categories'));
    }

    public function themVaoGio(Request $request, $id)
    {
        $truyen = Truyen::find($id);

        if (!$truyen) {
            return redirect('/')->with('error', 'Truyện không tồn tại!');
        }
        
        $soLuongMua = $request->input('so_luong', 1);
        $gioHang = session()->get('gio_hang', []);

        if(isset($gioHang[$id])) {
            $gioHang[$id]['so_luong'] += $soLuongMua;
        } else {
            $gioHang[$id] = [
                "ten_truyen" => $truyen->title,      
                "so_luong"   => $soLuongMua,
                "gia_ban"    => $truyen->price,      
                "hinh_anh"   => $truyen->cover_image  
            ];
        }

        session()->put('gio_hang', $gioHang);

        return redirect()->action([GioHangController::class, 'xemGioHang'])
                         ->with('added_to_cart', 'Đã thêm vào giỏ hàng thành công!');
    }

    /**
     * 3. Hàm xử lý TÌM KIẾM VÀ LỌC (Cho route /search)
     */
    public function search(Request $request)
    {
        $genres = $request->input('genres'); 
        $queryText = $request->input('query');
        
        $query = \App\Models\Truyen::query();

        if (!empty($genres)) {
            $query->whereIn('category_id', $genres);
        }

        if (!empty($queryText)) {
            $query->where('title', 'LIKE', "%{$queryText}%"); 
        }

        $stories = $query->get();
        $categories = \DB::table('categories')->get();

        return view('welcome', compact('stories', 'categories'));
    }

    /**
     * 4. Hàm hiển thị trang GIỎ HÀNG
     */
    public function xemGioHang()
    {
        return view('giohang.index');
    }

    /**
     * TÍNH NĂNG MỚI: XÓA 1 TRUYỆN KHỎI GIỎ HÀNG
     */
    public function xoaKhoiGio($id)
    {
        $gioHang = session()->get('gio_hang', []);

        if(isset($gioHang[$id])) {
            unset($gioHang[$id]); 
            session()->put('gio_hang', $gioHang); 
        }

        return redirect()->back()->with('removed_from_cart', 'Đã xóa truyện khỏi giỏ hàng!');
    }

    /**
     * 5. Hàm hiển thị trang Thanh toán (Checkout)
     */
    public function thanhToan()
    {
        $gioHang = session()->get('gio_hang', []);
        
        if(empty($gioHang)) {
            return redirect('/')->with('error', 'Giỏ hàng của bạn đang trống!');
        }

        return view('giohang.checkout', compact('gioHang'));
    }

    /**
     * 6. Xử lý đặt hàng thành công
     */
    public function xuLyThanhToan(Request $request)
    {
        $hoTen = $request->input('ho_ten');
        session()->forget('gio_hang'); 

        return redirect('/')->with('order_success', 'Cảm ơn ' . $hoTen . '! Đơn hàng đã được ghi nhận.');
    }

    /**
     * 7. Hiển thị chi tiết truyện
     */
    public function show($id)
    {
        $story = \App\Models\Truyen::findOrFail($id);
        return view('stories.show', compact('story'));
    }

    /**
     * 8. Lọc theo thể loại
     */
    public function theLoai($id)
    {
        $category = \DB::table('categories')->where('id', $id)->first();

       
        $stories = \App\Models\Truyen::where('category_id', $id)->get(); 

        return view('welcome', compact('stories', 'category'));
    }
}