@extends('layout.apps')
@section('title', 'إضافة سيارة جديدة')

@section('content')
    <div class="container mt-5 fade-in">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-8">
                <div class="card shadow-lg border-0 rounded-4 overflow-hidden" style="background: linear-gradient(135deg, rgba(255,255,255,0.95) 0%, rgba(255,255,255,0.85) 100%); backdrop-filter: blur(15px); border: 1px solid rgba(255,255,255,0.2);">
                    <div class="card-header text-center py-4 bg-primary text-white border-0 rounded-top">
                        <h2 class="mb-0"><i class="bi bi-plus-circle-fill me-2 fs-2"></i>إضافة سيارة جديدة</h2>
                        <p class="mb-0 mt-2 opacity-75">أدخل بيانات السيارة المفقودة لإضافتها إلى قاعدة البيانات</p>
                    </div>
                    <div class="card-body p-5">
                        @if (session('success'))
                            <div class="alert alert-success border-0 rounded-3 shadow-sm" role="alert">
                                <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-danger border-0 rounded-3 shadow-sm" role="alert">
                                <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
                            </div>
                        @endif

                        <form action="{{ route('store-car') }}" method="POST" class="needs-validation" novalidate>
                            @csrf

                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <label class="form-label fw-bold text-dark mb-2">
                                        <i class="bi bi-hash me-2 text-primary"></i>رقم الشاسيه
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control form-control-lg border-2 rounded-3 shadow-sm" name="chassis_number" placeholder="مثال: ABC123456789" required style="border-color: #e1e8ed;">
                                    <div class="invalid-feedback">
                                        يرجى إدخال رقم الشاسيه
                                    </div>
                                    <small class="form-text text-muted">يجب أن يكون فريد ويحتوي على 10-20 رقم</small>
                                </div>

                                <div class="col-md-6 mb-4">
                                    <label class="form-label fw-bold text-dark mb-2">
                                        <i class="bi bi-car-front me-2 text-primary"></i>الموديل
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control form-control-lg border-2 rounded-3 shadow-sm" name="model" placeholder="مثال: تويوتا كورولا" required style="border-color: #e1e8ed;">
                                    <div class="invalid-feedback">
                                        يرجى إدخال موديل السيارة
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <label class="form-label fw-bold text-dark mb-2">
                                        <i class="bi bi-palette me-2 text-primary"></i>اللون
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control form-control-lg border-2 rounded-3 shadow-sm" name="color" placeholder="مثال: أبيض" required style="border-color: #e1e8ed;">
                                    <div class="invalid-feedback">
                                        يرجى إدخال لون السيارة
                                    </div>
                                </div>

                                <div class="col-md-6 mb-4">
                                    <label class="form-label fw-bold text-dark mb-2">
                                        <i class="bi bi-geo-alt me-2 text-primary"></i>مكان العثور
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control form-control-lg border-2 rounded-3 shadow-sm" name="found_location" placeholder="مثال: شارع الاستقلال" required style="border-color: #e1e8ed;">
                                    <div class="invalid-feedback">
                                        يرجى إدخال مكان العثور على السيارة
                                    </div>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-bold text-dark mb-2">
                                    <i class="bi bi-shield-check me-2 text-primary"></i>قسم الشرطة
                                    <span class="text-danger">*</span>
                                </label>
                                <select class="form-select form-select-lg border-2 rounded-3 shadow-sm" name="police_station_id" required style="border-color: #e1e8ed;">
                                    <option value="">اختر قسم الشرطة</option>
                                    @foreach($policeStations as $station)
                                        <option value="{{ $station->id }}">{{ $station->name }}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">
                                    يرجى اختيار قسم الشرطة
                                </div>
                            </div>

                            <div class="text-center mt-4">
                                <button type="submit" class="btn btn-success btn-lg px-5 py-3 me-3 rounded-3 shadow-lg">
                                    <i class="bi bi-check-circle-fill me-2 fs-5"></i>حفظ السيارة
                                </button>
                                <a href="{{ route('admin-dashboard') }}" class="btn btn-outline-secondary btn-lg px-5 py-3 rounded-3">
                                    <i class="bi bi-arrow-left me-2"></i>العودة للوحة التحكم
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Bootstrap form validation
        (function () {
            'use strict'
            var forms = document.querySelectorAll('.needs-validation')
            Array.prototype.slice.call(forms)
                .forEach(function (form) {
                    form.addEventListener('submit', function (event) {
                        if (!form.checkValidity()) {
                            event.preventDefault()
                            event.stopPropagation()
                        }
                        form.classList.add('was-validated')
                    }, false)
                })
        })()
    </script>
@endsection
