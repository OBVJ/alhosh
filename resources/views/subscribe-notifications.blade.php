@extends('layout.apps')
@section('title', 'الاشتراك في خدمة الإشعارات')

@section('content')
    <div class="container mt-5 fade-in">
        <h2 class="text-center mb-4"><i class="bi bi-bell-plus me-2"></i>الاشتراك في خدمة الإشعارات</h2>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm border-info">
                    <div class="card-body">
                        <h5 class="card-title text-center mb-3">
                            <i class="bi bi-bell me-2 text-info"></i>هل تريد إشعار عند العثور على سيارتك؟
                        </h5>
                        <p class="text-center text-muted mb-4">
                            اشترك في خدمة الإشعارات وسيتم إشعارك فوراً عندما تقوم الشرطة بتخزين سيارتك المفقودة
                        </p>

                        <form action="{{ route('search') }}" method="GET" class="row g-3 justify-content-center align-items-end" id="subscriptionForm">
                            <div class="col-md-6">
                                <label for="chassis_number" class="form-label fw-bold">رقم الشاسيه</label>
                                <input type="text" class="form-control" id="chassis_number" name="chassis_number" placeholder="أدخل رقم الشاسيه" required>
                            </div>
                            <div class="col-md-6">
                                <label for="user_email" class="form-label fw-bold">البريد الإلكتروني</label>
                                <input type="email" class="form-control" id="user_email" name="user_email" placeholder="أدخل بريدك الإلكتروني" required>
                            </div>
                            <div class="col-12 text-center">
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" name="subscribe_notifications" value="1" id="subscribeCheck" checked>
                                    <label class="form-check-label fw-bold" for="subscribeCheck">
                                        اشتراك في الإشعارات
                                    </label>
                                </div>
                                <button type="submit" class="btn btn-info btn-lg">
                                    <i class="bi bi-bell-plus-fill me-2"></i>اشتراك الآن
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="text-center mt-4">
                    <a href="{{ route('index') }}" class="btn btn-secondary me-2">
                        <i class="bi bi-house me-2"></i>العودة للرئيسية
                    </a>
                    <a href="{{ route('notifications') }}" class="btn btn-outline-primary">
                        <i class="bi bi-bell me-2"></i>التحقق من الإشعارات
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('subscriptionForm').addEventListener('submit', function(e) {
            const checkbox = document.getElementById('subscribeCheck');
            if (!checkbox.checked) {
                e.preventDefault();
                alert('يرجى تحديد خيار الاشتراك في الإشعارات أولاً');
                checkbox.focus();
                return false;
            }
        });
    </script>
@endsection
