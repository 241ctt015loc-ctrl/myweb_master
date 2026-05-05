<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đệ Nhất Truyện - Thế Giới Truyện Tranh Online</title>
    
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>

    <header class="main-header">
        <nav class="navbar">
            <div class="logo">
                <a href="/">📚 <span>Đệ Nhất</span> Truyện</a>
            </div>

            <div class="search-container">
                <form action="{{ route('search') }}" method="GET" class="search-form">
                    <input type="text" name="query" placeholder="Tìm kiếm truyện bạn muốn mua..." value="{{ request('query') }}">
                    <button type="submit"><i class="fas fa-search"></i> Mua Ngay</button>
                </form>
            </div>

            <ul class="nav-links">
    <li><a href="{{ route('home') }}" class="nav-btn btn-home"><i class="fas fa-home"></i> Trang Chủ</a></li>
    <li><button onclick="openFilter()" class="nav-btn btn-cate"><i class="fas fa-filter"></i> Thể Loại</button></li>
    
    @auth
        <li><span style="color: white;">Chào, {{ Auth::user()->name }}</span></li>
        <li>
            <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                @csrf
                <button type="submit" class="nav-btn" style="background:none; border:none; color:white; cursor:pointer;">Đăng xuất</button>
            </form>
        </li>
    @else
        <li><a href="{{ route('login') }}" class="nav-btn"><i class="fas fa-user"></i> Đăng nhập</a></li>
        <li><a href="{{ route('register') }}" class="nav-btn"><i class="fas fa-user-plus"></i> Đăng ký</a></li>
    @endauth

    <li>
        <a href="{{ route('cart.index') }}" class="cart-icon">
            <i class="fas fa-shopping-cart"></i>
            @if(session('gio_hang'))
                <span class="badge">{{ count(session('gio_hang')) }}</span>
            @endif
        </a>
    </li>
</ul>
        </nav>
    </header>
<div id="filterModal" class="filter-modal">
    <div class="filter-content">
        <h3 class="modal-title"><i class="fas fa-tags"></i> Chọn Thể Loại</h3>
        
        <form action="{{ route('search') }}" method="GET">
            <div class="filter-grid">
                @if(isset($categories) && $categories->count() > 0)
                    @foreach($categories as $cat)
                        <label class="filter-item">
                            <input type="checkbox" name="genres[]" value="{{ $cat->id }}" 
                                {{ is_array(request('genres')) && in_array($cat->id, request('genres')) ? 'checked' : '' }}> 
                           <span>{{ $cat->name }}</span>
                        </label>
                    @endforeach
                @else
                    <p>Chưa có thể loại nào trong database.</p>
                @endif
            </div>

            <div class="filter-footer">
                <button type="button" class="btn-close-filter" onclick="closeFilter()">Đóng</button>
                <button type="submit" class="btn-submit-filter">Lọc Truyện</button>
            </div>
        </form>
    </div>
</div>


    <section class="hero-banner">
        <div class="banner-overlay"></div> 
        <div class="banner-content">
            <h2>Thế Giới Truyện Trong Tầm Tay</h2>
            <p>Khám phá hàng ngàn tựa truyện hấp dẫn nhất mọi thời đại</p>
            <a href="#danh-sach" class="btn-banner"><i class="fas fa-shopping-bag"></i> Mua Ngay</a>
        </div>
    </section>

    <main class="content-wrapper" id="danh-sach">
        <div class="section-header">
            <h3>🔥 Truyện Mới Cập Nhật</h3>
        </div>

        <div class="container">
            @forelse($stories as $story)
                <div class="story-card">
                    <a href="{{ route('story.show', $story->id) }}" style="text-decoration: none; color: inherit; display: block; flex-grow: 1;">
                        <div class="card-img">
                            <span class="tag-new">HOT</span>
                            <img src="{{ asset('images/' . $story->HinhAnh) }}" alt="{{ $story->TenTruyen }}">
                        </div>

                        <div class="card-info">
                            <h2>{{ $story->TenTruyen }}</h2>
                            <div>
                                {{-- Đã sửa $item thành $story để lấy đúng giá từ database --}}
                                <span class="price">{{ number_format($story->GiaBan, 0, ',', '.') }}đ</span>
                            </div>
                        </div>
                    </a>

                    <a href="{{ route('story.show', $story->id) }}" class="btn-buy">
                        <i class="fas fa-shopping-cart"></i> Mua Ngay
                    </a>
                </div>
            @empty
                <div style="grid-column: 1/-1; text-align: center; padding: 50px; background: white; border-radius: 10px; box-shadow: var(--shadow);">
                    <i class="fas fa-box-open" style="font-size: 40px; color: #ccc; margin-bottom: 15px;"></i>
                    <p style="font-size: 18px; color: #777;">Chưa có truyện nào trong danh sách.</p>
                </div>
            @endforelse 
        </div>
    </main>

    <footer class="main-footer">
        <div class="footer-bottom">
            <p>&copy; 2024 Đệ Nhất Truyện. Design by <strong>Cao Huy Lộc & Trần Thị Như Tiên</strong>.</p>
        </div>
    </footer>

    <script>
        function openFilter() { document.getElementById("filterModal").style.display = "flex"; }
        function closeFilter() { document.getElementById("filterModal").style.display = "none"; }
        window.onclick = function(event) { if (event.target == document.getElementById("filterModal")) closeFilter(); }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @if(session('order_success'))
    <script>
        Swal.fire({
            title: '🎉 Chúc mừng!',
            text: '{{ session('order_success') }}',
            icon: 'success',
            confirmButtonText: 'Tuyệt vời',
            confirmButtonColor: '#ff4757',
            backdrop: `rgba(0,0,123,0.4) url("https://media.giphy.com/media/v1.Y2lkPTc5MGI3NjExNHJndnBqZ3BqZ3BqZ3BqZ3BqZ3BqZ3BqZ3BqZ3BqZ3BqZ3BqZ3BqJmVwPXYxX2ludGVybmFsX2dpZl9ieV9pZCZjdD1n/l0MYt5jPR6QX5pnqM/giphy.gif") left top no-repeat`
        })
    </script>
    @endif
</body>
</html>