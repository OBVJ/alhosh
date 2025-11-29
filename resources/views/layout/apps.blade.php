<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', ' ')</title>

    <!-- ربط ملف CSS مخصص (إذا كان موجودًا) -->
    <link rel="stylesheet" href="\assets\css\bootstrap.min.css">
    <link rel="stylesheet" href="\assets\bootstrap-icons-1.11.3\font\bootstrap-icons.min.css">
    <link rel="stylesheet" href="\assets\css\custom.css">
    
</head>    
    <body dir="rtl">
        <div class="min-h-screen bg-gray-100">
            @include('layout.navigation')
     
    
        <div class="container mt-4">
            @yield('content')
        </div>
    
    
    <!-- ربط Bootstrap JS -->
    <script src="\assets\js\bootstrap.bundle.min.js"></script>
</body>
</html>
