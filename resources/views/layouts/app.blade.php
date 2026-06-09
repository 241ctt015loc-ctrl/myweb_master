<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Hệ thống Quản trị Admin</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">

    <style>
       
        html, body {
            background-color: #f3f4f6 !important;
            color: #1f2937 !important;
            font-family: system-ui, -apple-system, sans-serif;
        }

       
        .bg-white, table, .card, main {
            background-color: #ffffff !important;
            color: #1f2937 !important;
        }

        .py-12 { padding-top: 3rem; padding-bottom: 3rem; }
        .max-w-7xl { max-width: 1280px; margin: 0 auto; }
        .max-w-3xl { max-width: 768px; margin: 0 auto; }
        .mb-4 { margin-bottom: 1.5rem; }
        .mb-6 { margin-bottom: 2rem; }
        .p-4 { padding: 1.5rem; }
        .p-6 { padding: 2rem; }
      
        .grid { display: grid; gap: 1.5rem; }
        @media (min-width: 768px) {
            .md\:grid-cols-2 { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        }

        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1rem;
            border: 1px solid #e5e7eb;
        }
        th {
            background-color: #f9fafb !important;
            color: #4b5563 !important;
            font-weight: 600;
            padding: 12px 16px !important;
            border-bottom: 2px solid #e5e7eb !important;
        }
        td {
            padding: 14px 16px !important;
            border-bottom: 1px solid #e5e7eb !important;
            vertical-align: middle;
        }

        
        nav {
            background-color: #ffffff !important;
            border-bottom: 1px solid #e5e7eb;
            padding: 15px 20px;
            display: flex;
            gap: 20px;
            align-items: center;
        }
        nav a {
            color: #4b5563 !important;
            text-decoration: none !important;
            font-weight: 500;
        }
        nav a:hover { color: #1d4ed8 !important; }

        /* Ép giữ màu cho các nút bấm hành động (Sửa, Xóa) */
        .text-emerald-600 { color: #059669 !important; font-weight: bold; }
        .bg-amber-500, a[href*="edit"] { background-color: #ffc107 !important; color: #000 !important; border: none; padding: 5px 10px; border-radius: 4px; text-decoration: none; }
        .bg-rose-600, button { background-color: #dc3545 !important; color: #fff !important; border: none; padding: 5px 10px; border-radius: 4px; }
        .bg-indigo-600, a[href*="create"] { background-color: #0d6efd !important; color: #fff !important; border: none; padding: 8px 16px; border-radius: 6px; text-decoration: none; }
    </style>
</head>
<body>

    
    @include('layouts.navigation')

    
    @isset($header)
        <header class="bg-white border-bottom py-4 shadow-sm mb-4">
            <div class="max-w-7xl mx-auto px-3">
                {{ $header }}
            </div>
        </header>
    @endisset

    
    <main class="container-fluid">
        {{ $slot }}
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>