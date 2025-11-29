@extends('layout.apps')
@section('title', 'تسجيل الدخول - البحث عن السيارات المفقودة')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="search-hero fade-in">
                <h2 class="text-center mb-4">
                    <i class="bi bi-shield-lock me-2"></i>تسجيل الدخول
                </h2>

                <!-- Session Status -->
                @if (session('status'))
                    <div class="alert alert-success text-center mb-4">
                        <i class="bi bi-check-circle me-2"></i>{{ session('status') }}
                    </div>
                @endif

                <!-- Validation Errors -->
                @if ($errors->any())
                    <div class="alert alert-danger mb-4">
                        <i class="bi bi-exclamation-triangle me-2"></i>
                        <strong>يرجى تصحيح الأخطاء التالية:</strong>
                        <ul class="mb-0 mt-2">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}" novalidate>
                    @csrf

                    <!-- Email Address -->
                    <div class="mb-4">
                        <label for="email" class="form-label fw-bold">
                            <i class="bi bi-envelope me-2"></i>البريد الإلكتروني
                        </label>
                        <input id="email"
                               type="email"
                               class="form-control form-control-lg"
                               name="email"
                               value="{{ old('email') }}"
                               required
                               autofocus
                               autocomplete="username"
                               placeholder="أدخل بريدك الإلكتروني">
                        @error('email')
                            <div class="text-danger mt-1">
                                <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="mb-4">
                        <label for="password" class="form-label fw-bold">
                            <i class="bi bi-key me-2"></i>كلمة المرور
                        </label>
                        <input id="password"
                               type="password"
                               class="form-control form-control-lg"
                               name="password"
                               required
                               autocomplete="current-password"
                               placeholder="أدخل كلمة المرور">
                        @error('password')
                            <div class="text-danger mt-1">
                                <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Remember Me -->
                    <div class="mb-4">
                        <div class="form-check">
                            <input id="remember"
                                   type="checkbox"
                                   class="form-check-input"
                                   name="remember"
                                   {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label fw-bold" for="remember">
                                <i class="bi bi-clock me-1"></i>تذكرني
                            </label>
                        </div>
                    </div>

                    <div class="d-grid gap-3">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="bi bi-box-arrow-in-right me-2"></i>تسجيل الدخول
                        </button>

                        @if (Route::has('password.request'))
                            <div class="text-center">
                                <a href="{{ route('password.request') }}" class="text-decoration-none">
                                    <i class="bi bi-question-circle me-1"></i>هل نسيت كلمة المرور؟
                                </a>
                            </div>
                        @endif
                    </div>

                    <div class="text-center mt-4">
                        <small class="text-muted">
                            <i class="bi bi-info-circle me-1"></i>
                            يجب أن تكون موظف شرطة للوصول إلى النظام
                        </small>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
