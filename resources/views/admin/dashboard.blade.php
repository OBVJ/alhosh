@extends('layout.apps')
@section('title', 'لوحة التحكم')

@section('content')
    <div class="container mt-5 fade-in">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2><i class="bi bi-shield-lock me-2"></i>لوحة التحكم - السيارات المخزنة</h2>
            <a href="{{ route('add-car') }}" class="btn btn-success btn-lg">
                <i class="bi bi-plus-circle me-2"></i>إضافة سيارة جديدة
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <!-- Stats Cards -->
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card text-center border-0 shadow-sm" style="background: linear-gradient(135deg, #007bff 0%, #0056b3 100%); color: white;">
                    <div class="card-body py-4">
                        <i class="bi bi-car-front-fill fs-1 mb-3"></i>
                        <h4 class="card-title mb-2 fw-bold">{{ $cars->count() }}</h4>
                        <p class="card-text mb-0 fs-6">إجمالي السيارات المخزنة</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center border-0 shadow-sm" style="background: linear-gradient(135deg, #28a745 0%, #1e7e34 100%); color: white;">
                    <div class="card-body py-4">
                        <i class="bi bi-geo-alt-fill fs-1 mb-3"></i>
                        <h4 class="card-title mb-2 fw-bold">{{ $cars->unique('police_station_id')->count() }}</h4>
                        <p class="card-text mb-0 fs-6">أقسام الشرطة</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center border-0 shadow-sm" style="background: linear-gradient(135deg, #17a2b8 0%, #117a8b 100%); color: white;">
                    <div class="card-body py-4">
                        <i class="bi bi-search fs-1 mb-3"></i>
                        <h4 class="card-title mb-2 fw-bold">البحث</h4>
                        <p class="card-text mb-0 fs-6">إدارة السيارات المفقودة</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card bg-light border-0 shadow-sm">
                    <div class="card-body text-center">
                        <h5 class="card-title mb-3 text-dark"><i class="bi bi-gear-fill me-2 text-primary"></i>إجراءات سريعة</h5>
                        <div class="d-flex justify-content-center gap-3 flex-wrap">
                            <a href="{{ route('add-car') }}" class="btn btn-primary btn-lg">
                                <i class="bi bi-plus-circle-fill me-2"></i>إضافة سيارة
                            </a>
                            <a href="{{ route('police-stations.create') }}" class="btn btn-secondary btn-lg">
                                <i class="bi bi-building-add me-2"></i>إضافة قسم جديد
                            </a>
                            <a href="{{ route('police-stations.index') }}" class="btn btn-success btn-lg">
                                <i class="bi bi-building me-2"></i>إدارة الأقسام
                            </a>
                            <a href="{{ route('reports') }}" class="btn btn-warning btn-lg">
                                <i class="bi bi-bar-chart-line me-2"></i>التقارير
                            </a>
                            <a href="{{ route('index') }}" class="btn btn-info btn-lg">
                                <i class="bi bi-search me-2"></i>البحث عن سيارة
                            </a>
                        </div>
                    </div>
                </div>
            </div>
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
                                <div class="btn-group" role="group">
                                    <a href="{{ route('edit-car', $car->id) }}" class="btn btn-warning btn-sm"><i class="bi bi-pencil"></i> تعديل</a>

                                    @if($car->status === 'stored')
                                        <form action="{{ route('cars.mark-delivered', $car->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            <button type="submit" class="btn btn-success btn-sm" onclick="return confirm('هل أنت متأكد من تأكيد تسليم هذه السيارة لصاحبها؟')">
                                                <i class="bi bi-check-circle"></i> تم التسليم
                                            </button>
                                        </form>
                                    @else
                                        <span class="badge bg-success"><i class="bi bi-check-circle-fill me-1"></i>تم التسليم</span>
                                    @endif

                                    <form action="{{ route('delete-car', $car->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('هل أنت متأكد من حذف هذه السيارة؟')">
                                            <i class="bi bi-trash"></i> حذف
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
