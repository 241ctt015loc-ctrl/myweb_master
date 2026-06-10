<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $story->title }} - Chi tiết truyện</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --bg-color: #1a1a1a;
            --card-bg: #2d2d2d;
            --text-color: #eeeeee;
            --accent-color: #ff4757;
            --btn-hover: #ff6b81;
        }

        body {
            background-color: var(--bg-color);
            color: var(--text-color);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
        }

        .main-header {
            background: #000;
            padding: 15px 5%;
            box-shadow: 0 2px 10px rgba(0,0,0,0.5);
        }

        .navbar { display: flex; justify-content: space-between; align-items: center; }
        .logo a { color: white; text-decoration: none; font-size: 24px; font-weight: bold; }
        .logo span { color: var(--accent-color); }
        
        .back-link {
            color: #ccc;
            text-decoration: none;
            transition: 0.3s;
        }
        .back-link:hover { color: var(--accent-color); }

        .content-wrapper {
            max-width: 1100px;
            margin: 50px auto;
            padding: 20px;
        }

        .story-detail-container {
            display: flex;
            gap: 50px;
            background: var(--card-bg);
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.5);
            animation: fadeIn 0.8s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .detail-img { flex: 1; }
        .detail-img img {
            width: 100%;
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.4);
            transition: 0.5s;
        }
        .detail-img img:hover { transform: scale(1.02); }

        .detail-info { flex: 1.5; display: flex; flex-direction: column; }

    .story-title {
         font-size: 2.8rem;
         margin: 0;
        color: #ffffff; 
        text-shadow: 2px 2px 4px rgba(0,0,0,0.5); 
        -webkit-background-clip: initial;
        -webkit-text-fill-color: initial;
}
        .price-tag {
            font-size: 2rem;
            color: #2ed573;
            font-weight: bold;
            margin: 15px 0;
        }

        .description {
            line-height: 1.8;
            color: #bbb;
            margin: 20px 0;
            border-top: 1px solid #444;
            padding-top: 20px;
        }

        .description h3 { color: #fff; margin-bottom: 10px; }

        .purchase-zone {
            margin-top: auto;
            background: rgba(0,0,0,0.2);
            padding: 20px;
            border-radius: 12px;
        }

        .qty-input {
            background: #1a1a1a;
            border: 1px solid #444;
            color: #fff;
            padding: 10px;
            width: 70px;
            border-radius: 5px;
            margin: 0 10px;
        }

        .btn-buy {
            background: var(--accent-color);
            color: white;
            border: none;
            padding: 15px 30px;
            font-size: 1.2rem;
            font-weight: bold;
            border-radius: 10px;
            cursor: pointer;
            transition: 0.3s;
            width: 100%;
            margin-top: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .btn-buy:hover {
            background: var(--btn-hover);
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(255, 71, 87, 0.4);
        }

        @media (max-width: 768px) {
            .story-detail-container { flex-direction: column; padding: 20px; }
            .detail-img { width: 100%; max-width: 300px; margin: 0 auto; }
        }
    </style>
</head>
<body>
    <header class="main-header">
        <nav class="navbar">
            <div class="logo"><a href="/">📚 <span>Đệ Nhất</span> Truyện</a></div>
            <a href="/" class="back-link"><i class="fas fa-chevron-left"></i> Quay lại</a>
        </nav>
    </header>

    <main class="content-wrapper">
        <div class="story-detail-container">
            <div class="card-img">
                            <img src="{{ asset('images/' . $story->cover_image) }}" alt="{{ $story->title }}">
            </div>

            <div class="detail-info">
                <h1 class="story-title">{{ $story->title }}</h1>
                
                <div class="price-tag">
                    {{ number_format($story->price, 0, ',', '.') }} VNĐ
                </div>

                <div class="description">
                    <h3><i class="fas fa-book-open"></i> Giới thiệu nội dung:</h3>
                    <p>{{ $story->summary ?? 'Nội dung đang được cập nhật...' }}</p>
                </div>

                <div class="purchase-zone">
                    <form action="{{ route('cart.add', $story->id) }}" method="POST">
                        @csrf
                        <div style="display: flex; align-items: center; margin-bottom: 10px;">
                            <label>Số lượng:</label>
                            <input type="number" name="so_luong" value="1" min="1" max="100" class="qty-input">
                            <small style="color: #888;">(Sẵn có)</small>
                        </div>

                        <button type="submit" class="btn-buy">
                            <i class="fas fa-cart-shopping"></i> THÊM VÀO GIỎ HÀNG
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </main>
</body>
</html>