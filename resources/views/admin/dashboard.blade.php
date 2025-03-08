@extends('layout.apps')
@section('title', 'لوحة تحكم المسؤول')

@section('content')
<div class="container mt-5">
    <h2>لوحة تحكم المسؤول</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-hover table-striped">
        <thead class="thead-dark">
            <tr>
                <th>رقم الشاسيه</th>
                <th>الموديل</th>
                <th>اللون</th>
                <th>مكان العثور</th>
                <th>قسم الشرطة</th>
                <th>الإجراءات</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($cars as $car)
                <tr>
                    <td>{{ $car->chassis_number }}</td>
                    <td>{{ $car->model }}</td>
                    <td>{{ $car->color }}</td>
                    <td>{{ $car->found_location }}</td>
                    <td>{{ $car->police_station_id ?? 'غير محدد' }}</td>
                    <td>
                        <a href="{{ route('edit-car', $car->id) }}" class="btn btn-warning btn-sm">تعديل</a>
                        <a href="{{ route('add-car', $car->id) }}" class="btn btn-success btn-sm">أضافه</a>
                        <form action="{{ route('delete-car', $car->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('هل أنت متأكد من حذف هذه السيارة؟')">حذف</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
