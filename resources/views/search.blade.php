@extends('layout.apps')
@section('title', 'نتائج البحث')

@section('content')
    <div class="container mt-5 fade-in">
        <h2 class="text-center mb-4"><i class="bi bi-search-heart me-2"></i>نتائج البحث عن السيارة</h2>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        @if (isset($car))
            <div class="alert alert-success text-center mb-4">
                <i class="bi bi-check-circle-fill fs-2 mb-2"></i>
                <h4>تم العثور على السيارة!</h4>
                <p class="mb-0">السيارة موجودة في مخازن الشرطة</p>
            </div>

            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th><i class="bi bi-hash me-1"></i>رقم الشاسيه</th>
                            <th><i class="bi bi-car-front me-1"></i>الموديل</th>
                            <th><i class="bi bi-palette me-1"></i>اللون</th>
                            <th><i class="bi bi-geo-alt me-1"></i>مكان العثور</th>
                            <th><i class="bi bi-shield-check me-1"></i>قسم الشرطة</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ $car->chassis_number }}</td>
                            <td>{{ $car->model }}</td>
                            <td>{{ $car->color }}</td>
                            <td>{{ $car->found_location }}</td>
                            <td>{{ $car->policeStation->name ?? 'غير محدد' }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="text-center mt-4">
                <a href="{{ route('index') }}" class="btn btn-primary me-2"><i class="bi bi-arrow-right me-2"></i>بحث جديد</a>
                <a href="{{ route('notifications') }}" class="btn btn-info"><i class="bi bi-bell me-2"></i>التحقق من الإشعارات</a>
            </div>
        @elseif (isset($message))
            @if(isset($subscribed) && $subscribed)
                <div class="alert alert-success text-center mb-4">
                    <i class="bi bi-bell-fill fs-2 mb-2 text-success"></i>
                    <h4>تم الاشتراك في الإشعارات!</h4>
                    <p class="mb-0">سيتم إشعارك عندما يتم العثور على سيارتك</p>
                </div>
            @endif

            <div class="alert alert-warning text-center mb-4">
                <i class="bi bi-exclamation-triangle-fill fs-2 mb-2"></i>
                <h4>السيارة غير موجودة</h4>
                <p class="mb-0">{{ $message }}</p>
            </div>

            @if(!isset($subscribed) || !$subscribed)
                <div class="card shadow-sm border-warning mb-4">
                    <div class="card-body">
                        <h5 class="card-title text-center mb-3">
                            <i class="bi bi-bell me-2 text-warning"></i>هل تريد إشعار عند العثور على السيارة؟
                        </h5>
                        <p class="text-center text-muted mb-4">
                            اشترك في خدمة الإشعارات وسيتم إشعارك فوراً عندما تقوم الشرطة بتخزين سيارتك
                        </p>

                        <form action="{{ route('search') }}" method="GET" class="row g-3 justify-content-center align-items-end">
                            <input type="hidden" name="chassis_number" value="{{ request('chassis_number') }}">

                            <div class="col-md-5">
                                <label for="user_email" class="form-label fw-bold">البريد الإلكتروني</label>
                                <input type="email" class="form-control" id="user_email" name="user_email" placeholder="أدخل بريدك الإلكتروني" required>
                            </div>
                            <div class="col-md-3">
                                <div class="d-flex align-items-center h-100">
                                    <div class="form-check mb-0">
                                        <input class="form-check-input" type="checkbox" name="subscribe_notifications" value="1" id="subscribeCheck" checked>
                                        <label class="form-check-label fw-bold" for="subscribeCheck">
                                            اشتراك في الإشعارات
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <button type="submit" class="btn btn-warning w-100">
                                    <i class="bi bi-bell-plus-fill me-2"></i>اشتراك الآن
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            @endif

            <div class="text-center">
                <a href="{{ route('index') }}" class="btn btn-primary"><i class="bi bi-arrow-right me-2"></i>العودة للبحث</a>
            </div>
        @endif
    </div>
@endsection
