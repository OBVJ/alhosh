@extends('layout.apps')
@section('title', 'تعديل السيارة')

@section('content')
<div class="container mt-5">
    <h2>تعديل بيانات السيارة</h2>

    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form action="{{ route('update-car', $car->id) }}" method="POST">
        @csrf
        <!-- إذا كنت تستخدم PUT أو PATCH استخدم الطريقة المناسبة -->
        @method('PUT')
        
        <div class="mb-3">
            <label class="form-label">رقم الشاسيه:</label>
            <input type="text" class="form-control" name="chassis_number" value="{{ $car->chassis_number }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">الموديل:</label>
            <input type="text" class="form-control" name="model" value="{{ $car->model }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">اللون:</label>
            <input type="text" class="form-control" name="color" value="{{ $car->color }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">مكان العثور:</label>
            <input type="text" class="form-control" name="found_location" value="{{ $car->found_location }}" required>
        </div>

        <!-- إذا كنت تريد تعديل police_station_id، يمكنك إضافته هنا -->
        <div class="mb-3">
            <label class="form-label">قسم الشرطة (ID):</label>
            <input type="text" class="form-control" name="police_station_id" value="{{ $car->police_station_id }}">
        </div>

        <button type="submit" class="btn btn-success">حفظ التعديلات</button>
    </form>
</div>
@endsection
