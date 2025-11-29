@extends('layout.apps')
@section('title', 'التقارير والإحصائيات')

@section('content')
<div class="container mt-5 fade-in">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="bi bi-bar-chart-line me-2"></i>التقارير والإحصائيات</h2>
        <a href="{{ route('admin-dashboard') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-right me-2"></i>العودة للوحة التحكم
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <!-- Overview Statistics -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card text-center border-0 shadow-sm" style="background: linear-gradient(135deg, #007bff 0%, #0056b3 100%); color: white;">
                <div class="card-body py-4">
                    <i class="bi bi-car-front-fill fs-1 mb-3"></i>
                    <h4 class="card-title mb-2 fw-bold">{{ $totalCars }}</h4>
                    <p class="card-text mb-0 fs-6">إجمالي السيارات المسجلة</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center border-0 shadow-sm" style="background: linear-gradient(135deg, #ffc107 0%, #e0a800 100%); color: white;">
                <div class="card-body py-4">
                    <i class="bi bi-clock-history fs-1 mb-3"></i>
                    <h4 class="card-title mb-2 fw-bold">{{ $storedCars }}</h4>
                    <p class="card-text mb-0 fs-6">سيارات ما زالت مخزنة</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center border-0 shadow-sm" style="background: linear-gradient(135deg, #28a745 0%, #1e7e34 100%); color: white;">
                <div class="card-body py-4">
                    <i class="bi bi-check-circle-fill fs-1 mb-3"></i>
                    <h4 class="card-title mb-2 fw-bold">{{ $foundCars }}</h4>
                    <p class="card-text mb-0 fs-6">سيارات تم تسليمها لأصحابها</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Monthly Statistics -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title mb-0"><i class="bi bi-calendar-month me-2"></i>إحصائيات شهرية</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>الشهر</th>
                                    <th>إجمالي السيارات المضافة</th>
                                    <th>سيارات تم تسليمها</th>
                                    <th>نسبة التسليم</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($monthlyStats as $stat)
                                    <tr>
                                        <td>{{ $stat->year }}-{{ str_pad($stat->month, 2, '0', STR_PAD_LEFT) }}</td>
                                        <td><span class="badge bg-primary">{{ $stat->total_cars }}</span></td>
                                        <td><span class="badge bg-success">{{ $stat->found_cars }}</span></td>
                                        <td>
                                            @if($stat->total_cars > 0)
                                                <div class="progress" style="height: 20px;">
                                                    <div class="progress-bar bg-success" role="progressbar"
                                                         style="width: {{ ($stat->found_cars / $stat->total_cars) * 100 }}%"
                                                         aria-valuenow="{{ ($stat->found_cars / $stat->total_cars) * 100 }}"
                                                         aria-valuemin="0" aria-valuemax="100">
                                                        {{ round(($stat->found_cars / $stat->total_cars) * 100, 1) }}%
                                                    </div>
                                                </div>
                                            @else
                                                <span class="text-muted">لا توجد بيانات</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                @if($monthlyStats->isEmpty())
                                    <tr>
                                        <td colspan="4" class="text-center text-muted">لا توجد بيانات شهرية</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Police Station Statistics -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-success text-white">
                    <h5 class="card-title mb-0"><i class="bi bi-building me-2"></i>إحصائيات حسب مراكز الشرطة</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>مركز الشرطة</th>
                                    <th>إجمالي السيارات</th>
                                    <th>سيارات تم تسليمها</th>
                                    <th>سيارات ما زالت مخزنة</th>
                                    <th>نسبة التسليم</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($policeStationStats as $stat)
                                    @php
                                        $remainingCars = $stat->total_cars - $stat->found_cars;
                                    @endphp
                                    <tr>
                                        <td><strong>{{ $stat->station_name }}</strong></td>
                                        <td><span class="badge bg-primary">{{ $stat->total_cars }}</span></td>
                                        <td><span class="badge bg-success">{{ $stat->found_cars }}</span></td>
                                        <td><span class="badge bg-warning">{{ $remainingCars }}</span></td>
                                        <td>
                                            @if($stat->total_cars > 0)
                                                <div class="progress" style="height: 20px;">
                                                    <div class="progress-bar bg-success" role="progressbar"
                                                         style="width: {{ ($stat->found_cars / $stat->total_cars) * 100 }}%"
                                                         aria-valuenow="{{ ($stat->found_cars / $stat->total_cars) * 100 }}"
                                                         aria-valuemin="0" aria-valuemax="100">
                                                        {{ round(($stat->found_cars / $stat->total_cars) * 100, 1) }}%
                                                    </div>
                                                </div>
                                            @else
                                                <span class="text-muted">لا توجد بيانات</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                @if($policeStationStats->isEmpty())
                                    <tr>
                                        <td colspan="5" class="text-center text-muted">لا توجد بيانات لمراكز الشرطة</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Export Options -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card bg-light border-0 shadow-sm">
                <div class="card-body text-center">
                    <h6 class="card-title text-dark mb-3"><i class="bi bi-download me-2"></i>خيارات التصدير</h6>
                    <div class="d-flex justify-content-center gap-3">
                        <button class="btn btn-outline-primary" onclick="window.print()">
                            <i class="bi bi-printer me-2"></i>طباعة التقرير
                        </button>
                        <button class="btn btn-outline-success" onclick="exportToExcel()">
                            <i class="bi bi-file-earmark-spreadsheet me-2"></i>تصدير إلى Excel
                        </button>
                        <button class="btn btn-outline-info" onclick="exportToPDF()">
                            <i class="bi bi-file-earmark-pdf me-2"></i>تصدير إلى PDF
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function exportToExcel() {
    alert('ميزة التصدير إلى Excel ستكون متاحة قريباً');
}

function exportToPDF() {
    alert('ميزة التصدير إلى PDF ستكون متاحة قريباً');
}
</script>
@endsection
