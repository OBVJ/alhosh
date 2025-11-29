@extends('layout.apps')
@section('title', 'إدارة أقسام الشرطة')

@section('content')
    <div class="container mt-5 fade-in">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2><i class="bi bi-shield-check me-2"></i>إدارة أقسام الشرطة</h2>
            <a href="{{ route('police-stations.create') }}" class="btn btn-success btn-lg">
                <i class="bi bi-plus-circle me-2"></i>إضافة قسم جديد
            </a>
        </div>

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
                        <th><i class="bi bi-hash me-1"></i>رقم القسم</th>
                        <th><i class="bi bi-building me-1"></i>اسم القسم</th>
                        <th><i class="bi bi-geo-alt me-1"></i>الموقع</th>
                        <th><i class="bi bi-car-front me-1"></i>عدد السيارات</th>
                        <th><i class="bi bi-calendar me-1"></i>تاريخ الإنشاء</th>
                        <th><i class="bi bi-gear me-1"></i>الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($policeStations as $station)
                        <tr>
                            <td>{{ $station->id }}</td>
                            <td>{{ $station->name }}</td>
                            <td>{{ $station->location }}</td>
                            <td>
                                <span class="badge bg-primary">{{ $station->cars->count() }}</span>
                            </td>
                            <td>{{ $station->created_at->format('Y/m/d') }}</td>
                            <td>
                                <a href="{{ route('police-stations.edit', $station->id) }}" class="btn btn-warning btn-sm me-2">
                                    <i class="bi bi-pencil"></i> تعديل
                                </a>
                                <form action="{{ route('police-stations.destroy', $station->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('هل أنت متأكد من حذف هذا القسم؟')">
                                        <i class="bi bi-trash"></i> حذف
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4">
                                <i class="bi bi-info-circle fs-1 text-muted mb-3"></i>
                                <p class="text-muted">لا توجد أقسام شرطة مسجلة</p>
                                <a href="{{ route('police-stations.create') }}" class="btn btn-primary">
                                    <i class="bi bi-plus-circle me-2"></i>إضافة أول قسم
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="text-center mt-4">
            <a href="{{ route('admin-dashboard') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-2"></i>العودة للوحة التحكم
            </a>
        </div>
    </div>
@endsection
