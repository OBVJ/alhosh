@extends('layout.apps')
@section('title', 'البحث عن السيارات المفقودة')

@section('content')
    <div class="search-hero fade-in">
        <h2 class="text-center"><i class="bi bi-search me-2"></i>البحث عن السيارات المفقودة</h2>

        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <form action="{{ route('search') }}" method="GET" class="w-100">
            @csrf
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6">
                    <div class="mb-3">
                        <label for="chassis_number" class="form-label fw-bold"><i class="bi bi-car-front me-2"></i>أدخل رقم الشاسيه:</label>
                        <input type="text" class="form-control form-control-lg" id="chassis_number" name="chassis_number" placeholder="مثال: ABC123456789" required>
                        @if ($errors->has('chassis_number'))
                            <div class="alert alert-danger mt-2">{{ $errors->first('chassis_number') }}</div>
                        @endif
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary btn-lg"><i class="bi bi-search me-2"></i>بحث</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    @if (isset($car))
        <div class="container mt-5 fade-in">
            <h3 class="text-center mb-4"><i class="bi bi-table me-2"></i>نتائج البحث</h3>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th><i class="bi bi-hash me-1"></i>رقم الشاسيه</th>
                            <th><i class="bi bi-car-front me-1"></i>الموديل</th>
                            <th><i class="bi bi-palette me-1"></i>اللون</th>
                            <th><i class="bi bi-geo-alt me-1"></i>مكان العثور</th>
                            <th><i class="bi bi-shield-check me-1"></i>قسم الشرطة</th>
                            <th><i class="bi bi-gear me-1"></i>الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($cars as $car)
                            <tr>
                                <td>{{ $car->chassis_number }}</td>
                                <td>{{ $car->model }}</td>
                                <td>{{ $car->color }}</td>
                                <td>{{ $car->found_location }}</td>
                                <td>{{ $car->policeStation->name ?? 'غير محدد' }}</td>
                                <td>
                                    <a href="{{ route('edit-car', $car->id) }}" class="btn btn-warning btn-sm me-2"><i class="bi bi-pencil"></i> تعديل</a>
                                    <form action="{{ route('delete-car', $car->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('هل أنت متأكد من حذف هذه السيارة؟')"><i class="bi bi-trash"></i> حذف</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
@endsection
