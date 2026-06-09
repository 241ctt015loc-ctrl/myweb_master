<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giỏ Hàng - Đệ Nhất Truyện</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { background-color: #f4f6f9; padding: 50px 0; }
        .cart-container { background: white; padding: 30px; border-radius: 15px; box-shadow: 0 5px 20px rgba(0,0,0,0.1); }
        .img-cart { width: 80px; height: 110px; object-fit: cover; border-radius: 5px; }
        .total-price { font-size: 24px; color: #e44d26; font-weight: bold; }
        .btn-checkout {
            padding: 12px 30px; 
            background: linear-gradient(135deg, #ff7e5f, #e44d26); 
            color: white; 
            text-decoration: none; 
            border-radius: 8px; 
            font-weight: bold; 
            transition: 0.3s; 
            box-shadow: 0 4px 10px rgba(228, 77, 38, 0.3); 
            font-size: 1.1rem;
            display: inline-block;
        }
        .btn-checkout:hover {
            color: white;
            transform: scale(1.05);
            text-decoration: none;
        }
        .btn-back {
            padding: 12px 20px; 
            background-color: #2c3e50; 
            color: white; 
            text-decoration: none; 
            border-radius: 8px; 
            font-weight: bold; 
            transition: 0.3s;
            display: inline-block;
        }
        .btn-back:hover {
            background-color: #1a252f;
            color: white;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="cart-container">
            <h2 class="mb-4 text-center">🛒 GIỎ HÀNG CỦA BẠN</h2>
            
            <table class="table table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th>Hình ảnh</th>
                        <th>Tên truyện</th>
                        <th>Giá</th>
                        <th>Số lượng</th>
                        <th>Thành tiền</th>
                        <th class="text-center">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @php $total = 0; @endphp
                    
                    @if(session('gio_hang') && count(session('gio_hang')) > 0)
                        @foreach(session('gio_hang') as $id => $details)
                            @php $total += (float)$details['gia_ban'] * $details['so_luong']; @endphp
                            
                            <tr>
                                {{-- ĐÃ ĐỒNG BỘ: Đổi sang thư mục images/ để hiển thị ảnh chính xác --}}
                                <td><img src="{{ asset('images/' . $details['hinh_anh']) }}" class="img-cart" alt="Bìa truyện"></td>
                                <td class="align-middle"><strong>{{ $details['ten_truyen'] }}</strong></td>
                                
                                <td class="align-middle">{{ number_format((float)$details['gia_ban'], 0, ',', '.') }} đ</td>
                                <td class="align-middle">{{ $details['so_luong'] }}</td>
                                
                                <td class="align-middle text-danger font-weight-bold">
                                    {{ number_format((float)$details['gia_ban'] * $details['so_luong'], 0, ',', '.') }} đ
                                </td>
                                
                                <td class="align-middle text-center">
                                    <a href="{{ route('cart.remove', $id) }}" class="btn btn-sm btn-danger" style="border-radius: 5px;">
                                        <i class="fas fa-trash"></i> Xóa
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">
                                <h4>Giỏ hàng của bạn đang trống!</h4>
                                <p>Hãy quay lại trang chủ để chọn thêm truyện nhé.</p>
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>

            <div class="d-flex justify-content-between align-items-end mt-4 pt-3 border-top">
                <a href="{{ url('/') }}" class="btn-back">⬅ Tiếp tục chọn truyện</a>
                
                <div class="text-right">
                    <h4 class="mb-3">Tổng thanh toán: <span class="total-price">{{ number_format($total, 0, ',', '.') }} VNĐ</span></h4>
                    
                    @if(session('gio_hang') && count(session('gio_hang')) > 0)
                        <a href="{{ route('cart.checkout') }}" class="btn-checkout">Thanh toán ngay ➡</a>
                    @endif
                </div>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @if(session('added_to_cart'))
    <script>
        Swal.mixin({
          toast: true,
          position: 'top-end',
          showConfirmButton: false,
          timer: 3000,
          timerProgressBar: true,
        }).fire({
          icon: 'success',
          title: '{{ session("added_to_cart") }}'
        })
    </script>
    @endif

    @if(session('removed_from_cart'))
    <script>
        Swal.mixin({
          toast: true,
          position: 'top-end',
          showConfirmButton: false,
          timer: 3000,
          timerProgressBar: true,
        }).fire({
          icon: 'warning',
          title: '{{ session("removed_from_cart") }}'
        })
    </script>
    @endif
</body>
</html>