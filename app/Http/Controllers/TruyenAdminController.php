<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Truyen;
use App\Models\Category;
use Illuminate\Support\Str;

class TruyenAdminController extends Controller
{
    /**
     * Trang danh sách truyện cho Admin
     */
    public function index()
    {
        $stories = Truyen::with('category')->latest()->get();
        return view('admin.truyen.index', compact('stories'));
    }

    /**
     * Form thêm truyện mới
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.truyen.create', compact('categories'));
    }

    /**
     * Lưu truyện mới vào database (Định dạng viết liền không dấu: kiemlai.webp)
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price'       => 'required|numeric|min:0',
            'stock'       => 'required|integer|min:0', 
            'summary'     => 'nullable|string',
            'cover_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data = $request->only(['title', 'category_id', 'price', 'stock', 'summary']);
        $data['slug'] = Str::slug($request->title) . '-' . time();

        // 🛠️ XỬ LÝ UPLOAD ẢNH: Viết liền không dấu + đuôi .webp
        if ($request->hasFile('cover_image')) {
            $file = $request->file('cover_image');
            
            // Xử lý tạo tên file: "Kiếm Lai" -> "kiem-lai" -> "kiemlai.webp"
            $fileName = Str::replace('-', '', Str::slug($request->title)) . '.webp';
            
            // Di chuyển file ảnh vào thư mục public/covers/
            $file->move(public_path('covers'), $fileName);
            
            // 🔥 ĐẨY LÊN SQL: Chỉ lưu đúng tên file viết liền sạch sẽ (Ví dụ: kiemlai.webp)
            $data['cover_image'] = $fileName;
        }

        Truyen::create($data);

        return redirect()->route('admin.truyen.index')
                         ->with('success', 'Đã thêm truyện thành công!');
    }

    /**
     * Form chỉnh sửa truyện
     */
    public function edit($id)
    {
        $story      = Truyen::findOrFail($id);
        $categories = Category::all();
        return view('admin.truyen.edit', compact('story', 'categories'));
    }

    /**
     * Lưu chỉnh sửa vào database (Cập nhật ảnh viết liền không dấu)
     */
    public function update(Request $request, $id)
    {
        $story = Truyen::findOrFail($id);

        $request->validate([
            'title'       => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price'       => 'required|numeric|min:0',
            'stock'       => 'required|integer|min:0', 
            'summary'     => 'nullable|string',
            'cover_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data = $request->only(['title', 'category_id', 'price', 'stock', 'summary']);

        // 🛠️ XỬ LÝ UPLOAD ẢNH CHO FORM CẬP NHẬT
        if ($request->hasFile('cover_image')) {
            $file = $request->file('cover_image');
            
            // Tạo tên file mới viết liền không dấu
            $fileName = Str::replace('-', '', Str::slug($request->title)) . '.webp';
            
            // Tìm và xóa file ảnh cũ trên ổ đĩa để tránh rác host
            $oldPath = str_contains($story->cover_image, 'covers/') ? public_path($story->cover_image) : public_path('covers/' . $story->cover_image);
            if ($story->cover_image && file_exists($oldPath)) {
                @unlink($oldPath);
            }
            
            // Di chuyển file ảnh mới vào thư mục public/covers/
            $file->move(public_path('covers'), $fileName);
            
            // 🔥 ĐẨY LÊN SQL: Cập nhật tên file dạng viết liền sạch sẽ
            $data['cover_image'] = $fileName;
        }

        $story->update($data);

        return redirect()->route('admin.truyen.index')
                         ->with('success', 'Đã cập nhật truyện thành công!');
    }

    /**
     * Xóa truyện và dọn dẹp file ảnh tương ứng
     */
    public function destroy($id)
    {
        $story = Truyen::findOrFail($id);
        
        // Xác định đường dẫn thực tế để link tới ảnh và xóa file
        $imagePath = str_contains($story->cover_image, 'covers/') ? public_path($story->cover_image) : public_path('covers/' . $story->cover_image);
        if ($story->cover_image && file_exists($imagePath)) {
            @unlink($imagePath);
        }

        $story->delete();

        return redirect()->route('admin.truyen.index')
                         ->with('success', 'Đã xóa truyện thành công!');
    }
}