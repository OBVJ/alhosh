<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', ' ')</title>

    <!-- ربط ملف CSS مخصص (إذا كان موجودًا) -->
    <link rel="stylesheet" href="\assets\css\bootstrap.min.css">
    <link rel="stylesheet" href="\assets\bootstrap-icons-1.11.3\font\bootstrap-icons.min.css">
    
</head>    
    <body dir="rtl">

        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container">
                <a class="navbar-brand" href="{{ route('index') }}">البحث عن السيارات المفقودة</a>
                <div class="collapse navbar-collapse">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item"><a class="nav-link" href="{{ route('index') }}">الرئيسية</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('search') }}">بحث</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('dashboard') }}">لوحة التحكم</a></li>
                    </ul>
                </div>
            </div>
        </nav>
    
        <div class="container mt-4">
            @yield('content')
        </div>
    
    
    <!-- ربط Bootstrap JS -->
    <script src="\assets\js\bootstrap.bundle.min.js"></script>
</body>
</html>
