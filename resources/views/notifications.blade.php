@extends('layout.apps')
@section('title', 'الإشعارات')

@section('content')
    <div class="container mt-5 fade-in">
        <h2 class="text-center mb-4"><i class="bi bi-bell me-2"></i>التحقق من الإشعارات</h2>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <!-- نموذج البحث عن الإشعارات -->
        <div class="card shadow-sm mb-5" style="background: linear-gradient(135deg, rgba(255,255,255,0.9) 0%, rgba(255,255,255,0.7) 100%); backdrop-filter: blur(10px);">
            <div class="card-body p-4">
                <h5 class="card-title text-center mb-3">
                    <i class="bi bi-search me-2 text-primary"></i>البحث عن إشعاراتك
                </h5>
                <p class="text-center text-muted mb-4">
                    أدخل البريد الإلكتروني الذي استخدمته عند الاشتراك في الإشعارات
                </p>

                <form action="{{ route('notifications') }}" method="GET" class="row g-3 justify-content-center">
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                            <input type="email" class="form-control form-control-lg" name="email"
                                   placeholder="أدخل بريدك الإلكتروني"
                                   value="{{ $email ?? '' }}" required>
                            <button class="btn btn-primary" type="submit">
                                <i class="bi bi-search me-2"></i>بحث
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        @if(isset($notifications))
            <!-- عرض الإشعارات -->
            <div class="row">
                <div class="col-12">
                    <h4 class="mb-3">
                        <i class="bi bi-bell-fill me-2 text-primary"></i>
                        إشعاراتك ({{ $notifications->count() }})
                    </h4>

                    @if($notifications->count() > 0)
                        <div class="row g-3">
                            @foreach($notifications as $notification)
                                <div class="col-md-6 col-lg-4">
                                    <div class="card h-100 border-0 shadow-sm {{ $notification->notified ? 'border-success' : 'border-warning' }}"
                                         style="background: white;">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center mb-2">
                                                <i class="bi bi-car-front-fill fs-4 me-2 {{ $notification->notified ? 'text-success' : 'text-warning' }}"></i>
                                                <h6 class="card-title mb-0">
                                                    رقم الشاسيه: {{ $notification->chassis_number }}
                                                </h6>
                                            </div>

                                            <div class="mb-2">
                                                <small class="text-muted">
                                                    <i class="bi bi-calendar me-1"></i>
                                                    تاريخ البحث: {{ $notification->search_date->format('Y/m/d H:i') }}
                                                </small>
                                            </div>

                                            @if($notification->notified)
                                                <div class="alert alert-success py-2 mb-2">
                                                    <i class="bi bi-check-circle-fill me-1"></i>
                                                    <strong>تم العثور على السيارة!</strong>
                                                    <br>
                                                    <small class="text-muted">
                                                        تاريخ الإشعار: {{ $notification->notification_date->format('Y/m/d H:i') }}
                                                    </small>
                                                </div>

                                                @if($notification->car)
                                                    <div class="bg-light p-2 rounded">
                                                        <small>
                                                            <strong>تفاصيل السيارة:</strong><br>
                                                            الموديل: {{ $notification->car->model }}<br>
                                                            اللون: {{ $notification->car->color }}<br>
                                                            مكان العثور: {{ $notification->car->found_location }}<br>
                                                            قسم الشرطة: {{ $notification->car->policeStation->name ?? 'غير محدد' }}
                                                        </small>
                                                    </div>
                                                @endif
                                            @else
                                                <div class="alert alert-warning py-2 mb-2">
                                                    <i class="bi bi-clock me-1"></i>
                                                    <strong>في انتظار</strong>
                                                    <br>
                                                    <small>سيتم إشعارك عند العثور على السيارة</small>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="bi bi-info-circle fs-1 text-muted mb-3"></i>
                            <h5 class="text-muted">لا توجد إشعارات</h5>
                            <p class="text-muted">لم يتم العثور على أي إشعارات لهذا البريد الإلكتروني</p>
                        </div>
                    @endif
                </div>
            </div>
        @elseif(isset($error))
            <div class="alert alert-danger text-center">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                {{ $error }}
            </div>
        @endif

        <div class="text-center mt-4">
            <a href="{{ route('index') }}" class="btn btn-primary">
                <i class="bi bi-house me-2"></i>العودة للرئيسية
            </a>
        </div>
    </div>
@endsection
