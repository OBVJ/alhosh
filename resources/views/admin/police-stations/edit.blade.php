@extends('layout.apps')
@section('title', 'تعديل قسم الشرطة')

@section('content')
    <div class="container mt-5 fade-in">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-8">
                <div class="card shadow-lg border-0 rounded-4 overflow-hidden" style="background: linear-gradient(135deg, rgba(255,255,255,0.95) 0%, rgba(255,255,255,0.85) 100%); backdrop-filter: blur(15px); border: 1px solid rgba(255,255,255,0.2);">
                    <div class="card-header text-center py-4 bg-success text-white border-0 rounded-top">
                        <h2 class="mb-0"><i class="bi bi-pencil-square me-2 fs-2"></i>تعديل قسم الشرطة</h2>
                        <p class="mb-0 mt-2 opacity-75">تحديث بيانات قسم الشرطة</p>
                    </div>
                    <div class="card-body p-5">
                        @if (session('error'))
                            <div class="alert alert-danger border-0 rounded-3 shadow-sm" role="alert">
                                <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
                            </div>
                        @endif

                        <form action="{{ route('police-stations.update', $policeStation->id) }}" method="POST" class="needs-validation" novalidate>
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <label class="form-label fw-bold text-dark mb-2">
                                        <i class="bi bi-building me-2 text-primary"></i>اسم القسم
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control form-control-lg border-2 rounded-3 shadow-sm" name="name" value="{{ $policeStation->name }}" placeholder="مثال: مركز الشرطة الأول" required style="border-color: #e1e8ed;">
                                    <div class="invalid-feedback">
                                        يرجى إدخال اسم القسم
                                    </div>
                                    <small class="form-text text-muted">يجب أن يكون اسم فريد ولا يزيد عن 100 حرف</small>
                                </div>

                                <div class="col-md-6 mb-4">
                                    <label class="form-label fw-bold text-dark mb-2">
                                        <i class="bi bi-geo-alt me-2 text-primary"></i>الموقع
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control form-control-lg border-2 rounded-3 shadow-sm" name="location" value="{{ $policeStation->location }}" placeholder="مثال: وسط المدينة" required style="border-color: #e1e8ed;">
                                    <div class="invalid-feedback">
                                        يرجى إدخال موقع القسم
                                    </div>
                                    <small class="form-text text-muted">وصف دقيق لموقع قسم الشرطة</small>
                                </div>
                            </div>

                            <div class="text-center mt-4">
                                <button type="submit" class="btn btn-success btn-lg px-5 py-3 me-3 rounded-3 shadow-lg">
                                    <i class="bi bi-check-circle-fill me-2 fs-5"></i>حفظ التعديلات
                                </button>
                                <a href="{{ route('police-stations.index') }}" class="btn btn-outline-secondary btn-lg px-5 py-3 rounded-3">
                                    <i class="bi bi-arrow-left me-2"></i>العودة للقائمة
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
