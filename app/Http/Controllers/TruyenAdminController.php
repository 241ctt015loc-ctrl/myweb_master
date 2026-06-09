<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Truyen;
use App\Models\Category;
use Illuminate\Support\Str;

class TruyenAdminController extends Controller
{
    /**
     * Hiển thị danh sách truyện
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
     * Xử lý lưu truyện mới vào Database
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

        if ($request->hasFile('cover_image')) {
            $file = $request->file('cover_image');      

            $fileName = Str::replace('-', '', Str::slug($request->title)) . '-' . time() . '.' . $file->getClientOriginalExtension();

            $file->move(public_path('images'), $fileName);

            $data['cover_image'] = $fileName;
        }

        // Tạo bản ghi mới thông qua phương thức save() để tránh lỗi fillable ngầm nếu cache chưa xóa
        $story = new Truyen();
        $story->title       = $data['title'];
        $story->category_id = $data['category_id'];
        $story->price       = $data['price'];
        $story->stock       = $data['stock'];
        $story->summary     = $data['summary'];
        $story->slug        = $data['slug'];
        $story->cover_image = $data['cover_image'] ?? null;
        $story->save();

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
     * Xử lý cập nhật thông tin truyện
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
        
        // Luôn cập nhật lại slug mới đề phòng trường hợp bạn đổi tiêu đề truyện
        $data['slug'] = Str::slug($request->title) . '-' . time();

        if ($request->hasFile('cover_image')) {
            $file = $request->file('cover_image');
            
            // Đặt tên file giữ đuôi ảnh gốc và lưu vào thư mục 'images'
            $fileName = Str::replace('-', '', Str::slug($request->title)) . '-' . time() . '.' . $file->getClientOriginalExtension();
            
            // Xóa ảnh cũ nằm ở thư mục public/images (nếu tồn tại)
            if ($story->cover_image) {
                $oldPath = public_path('images/' . $story->cover_image);
                if (file_exists($oldPath)) {
                    @unlink($oldPath);
                }
            }
            
            // Di chuyển file mới vào thư mục public/images
            $file->move(public_path('images'), $fileName);
            
            $data['cover_image'] = $fileName;
        }

        // Cập nhật dữ liệu vào bản ghi hiện tại thay vì tạo mới
        $story->update($data);

        return redirect()->route('admin.truyen.index')
                         ->with('success', 'Đã cập nhật thông tin truyện thành công!');
    }

    /**
     * Xử lý xóa truyện khỏi hệ thống
     */
    public function destroy($id)
    {
        $story = Truyen::findOrFail($id);
        
        // Xóa file ảnh vật lý nằm trong thư mục public/images trước khi xóa bản ghi
        if ($story->cover_image) {
            $imagePath = public_path('images/' . $story->cover_image);
            if (file_exists($imagePath)) {
                @unlink($imagePath);
            }
        }

        $story->delete();

        return redirect()->route('admin.truyen.index')
                         ->with('success', 'Đã xóa truyện thành công!');
    }
}