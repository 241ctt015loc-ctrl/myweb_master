<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Thêm truyện mới - Admin</title>

    <link rel="stylesheet" href="{{ asset('css/admin-custom.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>

    <div class="form-container">
        
        {{-- Tiêu đề trang --}}
        <div class="page-header">
            <h2 class="fw-bold m-0 text-dark">➕ Thêm truyện mới</h2>
        </div>

        {{-- Hiển thị lỗi Validation nếu nhập thiếu/sai dữ liệu --}}
        @if($errors->any())
            <div class="alert alert-danger shadow-sm mb-4 border-0" style="border-left: 4px solid #ef4444 !important; background: white;">
                <ul class="mb-0 ps-3 text-danger fw-medium">
                    @foreach($errors->all() as $e)
                        <li>{{ $e }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Khung Form chính ăn theo style hệ thống --}}
        <div class="card main-card p-4 shadow-sm bg-white">
            <form action="{{ route('admin.truyen.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- Tên truyện --}}
                <div class="mb-4">
                    <label class="form-label">Tên truyện <span class="required">*</span></label>
                    <input type="text" name="title" 
                           value="{{ old('title') }}" 
                           class="form-control" 
                           placeholder="Nhập tên truyện..."
                           required>
                </div>

                {{-- Thể loại --}}
                <div class="mb-4">
                    <label class="form-label">Thể loại <span class="required">*</span></label>
                    <select name="category_id" class="form-select" required>
                        <option value="">-- Chọn thể loại --</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Giá và Số lượng tồn kho (Chia làm 2 cột song song) --}}
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label class="form-label">Giá (VNĐ) <span class="required">*</span></label>
                        <input type="number" name="price" 
                               value="{{ old('price', 0) }}" min="0" 
                               class="form-control" 
                               required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Số lượng nhập kho <span class="required">*</span></label>
                        <input type="number" name="stock" 
                               value="{{ old('stock', 0) }}" min="0" 
                               class="form-control" 
                               required>
                    </div>
                </div>

                {{-- Tóm tắt truyện --}}
                <div class="mb-4">
                    <label class="form-label">Tóm tắt truyện</label>
                    <textarea name="summary" rows="4" 
                              class="form-control" 
                              placeholder="Nhập nội dung tóm tắt cốt truyện...">{{ old('summary') }}</textarea>
                </div>

                {{-- Khhu vực nhập ảnh bìa truyện --}}
                <div class="mb-4" style="background-color: #f8fafc; padding: 15px; border-radius: 8px; border: 1px solid #e2e8f0;">
                    <label class="form-label" style="font-weight: 600; color: #334155;">Ảnh bìa truyện</label>
                    
                    <input type="file" name="cover_image" id="cover_image_input" accept="image/*" class="form-control" style="border: 2px solid #cbd5e1;">
                    <div style="font-size: 13px; color: #64748b; margin-top: 5px;">Hệ thống tự động lưu tên file viết liền không dấu dạng (.webp).</div>

                    {{-- Khung hiển thị ảnh xem trước --}}
                    <div id="preview_box" style="display: none; width: 140px; height: 190px; margin-top: 15px; border-radius: 6px; overflow: hidden; border: 2px dashed #94a3b8; background: #f1f5f9;">
                        <img id="preview_img" src="" alt="Xem trước ảnh bìa" style="width: 100%; height: 100%; object-fit: cover;">
                    </div>
                </div>

                {{-- Nhóm nút hành động ở chân form --}}
                <div class="d-flex justify-content-between align-items-center pt-3 border-top mt-4">
                    <a href="{{ route('admin.truyen.index') }}" class="btn btn-light border text-secondary">
                        <i class="fa-solid fa-arrow-left me-1"></i> Quay lại danh sách
                    </a>
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="fa-regular fa-floppy-disk me-1"></i> Lưu truyện mới
                    </button>
                </div>
            </form>
        </div>

    </div>

    {{-- Bộ Script bắt sự kiện thay đổi file để tạo Preview ảnh --}}
    <script>
        document.getElementById('cover_image_input').addEventListener('change', function(event) {
            const file = event.target.files[0];
            const previewBox = document.getElementById('preview_box');
            const previewImg = document.getElementById('preview_img');

            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImg.src = e.target.result;
                    previewBox.style.display = 'block';
                }
                reader.readAsDataURL(file);
            } else {
                previewBox.style.display = 'none';
            }
        });
    </script>

</body>
</html>