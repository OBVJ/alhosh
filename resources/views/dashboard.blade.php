@extends('layout.apps')
@section('title', 'لوحة التحكم')

@section('content')
    <div class="container mt-5 fade-in">
        <h2 class="text-center mb-4"><i class="bi bi-speedometer2 me-2"></i>لوحة التحكم - السيارات المخزنة</h2>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

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
@endsection
