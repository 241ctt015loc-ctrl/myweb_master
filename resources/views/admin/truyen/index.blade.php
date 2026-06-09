<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Hệ thống Quản lý Truyện (Admin)</title>
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <link rel="stylesheet" href="{{ asset('css/admin-custom.css') }}">
</head>
<body>

    <div class="admin-container mt-4 px-4">
        
  
        <div class="page-header d-flex justify-content-between align-items-center mb-4 pb-3 border-bottom">
            <div class="d-flex align-items-center gap-3">
                <h3 class="fw-bold m-0 text-dark">
                    <i class="fa-solid fa-book-open text-primary me-2"></i>Hệ thống Quản lý Truyện
                </h3>
                <a href="{{ url('/') }}" class="btn btn-light btn-sm shadow-sm border text-secondary fw-semibold">
                    <i class="fa-solid fa-house me-1"></i> Về trang chủ
                </a>
            </div>
            <a href="{{ route('admin.truyen.create') }}" class="btn btn-primary shadow-sm fw-semibold">
                <i class="fa-solid fa-plus me-1"></i> Thêm truyện mới
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm mb-4 border-0" role="alert" style="border-left: 4px solid #10b981 !important; background: white;">
                <span class="text-success fw-medium"><i class="fa-solid fa-circle-check me-2"></i>{{ session('success') }}</span>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card main-card shadow-sm border-0 bg-white rounded-3">
            <div class="card-header bg-light border-bottom py-3">
                <h5 class="m-0 fw-bold text-secondary"><i class="fa-solid fa-list me-2"></i>Danh sách truyện trong hệ thống</h5>
            </div>
            
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th class="px-4" style="width: 6%">#</th>
                            <th style="width: 12%">Hình ảnh</th>
                            <th>Tên truyện</th>
                            <th style="width: 18%">Thể loại</th>
                            <th style="width: 15%">Giá bán</th>
                            <th class="text-center" style="width: 20%">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($stories as $story)
                        <tr>
                            <td class="fw-medium text-muted px-4">{{ $loop->iteration }}</td>
                            <td>
                                {{-- ĐÃ SỬA: Ép cứng kích thước hiển thị ảnh để không bị vỡ giao diện --}}
                                <div class="cover-wrapper shadow-sm rounded border bg-light d-flex align-items-center justify-content-center" style="width: 55px; height: 75px; overflow: hidden;">
                                    @if($story->cover_image)
                                        <img src="{{ asset('images/' . $story->cover_image) }}" 
                                             alt="Bìa truyện"
                                             style="width: 100%; height: 100%; object-fit: cover;">
                                    @else
                                        <i class="fa-solid fa-book text-muted" style="font-size: 1.5rem;"></i>
                                    @endif
                                </div>
                            </td>
                            <td class="fw-bold text-dark fs-6">{{ $story->title }}</td>
                            <td>
                                <span class="badge bg-secondary px-2 py-2 rounded" style="font-size: 0.85rem; font-weight: 500;">
                                    <i class="fa-solid fa-tags me-1 small"></i>{{ $story->category->name ?? 'Chưa rõ' }}
                                </span>
                            </td>
                            <td class="fw-bold text-danger fs-6">
                                {{ number_format($story->price, 0, ',', '.') }}đ
                            </td>
                            <td>
                                <div class="d-flex gap-2 justify-content-center">
                                    <a href="{{ route('admin.truyen.edit', $story->id) }}" class="btn btn-warning btn-sm text-white px-3 fw-medium">
                                        <i class="fa-regular fa-pen-to-square me-1"></i> Sửa
                                    </a>
                                    <form action="{{ route('admin.truyen.destroy', $story->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Bạn có chắc chắn muốn xóa truyện này?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm px-3 fw-medium">
                                            <i class="fa-regular fa-trash-can me-1"></i> Xóa
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-5 fs-6">
                                <i class="fa-solid fa-folder-open d-block mb-2 fs-2 text-secondary"></i> Hệ thống chưa có dữ liệu truyện.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>