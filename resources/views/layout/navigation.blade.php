<nav class="navbar navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand" href="{{ route('index') }}">
            <i class="bi bi-car-front-fill me-2"></i>البحث عن السيارات المفقودة
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('index') }}">
                        <i class="bi bi-house-door me-1"></i>الرئيسية
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('search') }}">
                        <i class="bi bi-search me-1"></i>بحث
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('notifications') }}">
                        <i class="bi bi-bell me-1"></i>إشعاراتي
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin-dashboard') }}">
                        <i class="bi bi-shield-check me-1"></i>خاص بالشرطة
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
