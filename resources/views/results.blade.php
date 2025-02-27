@extends('layout.apps')
@section('title','نتائج البحث')

@section('content')
    <div class="container mt-5">
        <h2>نتائج البحث عن السيارة</h2>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        @if (isset($car))
            <h3 class="mt-5">النتيجة</h3>
            <table class="table table-bordered table-hover table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th>رقم الشاسيه</th>
                        <th>الموديل</th>
                        <th>اللون</th>
                        <th>مكان العثور</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ $car->chassis_number }}</td>
                        <td>{{ $car->model }}</td>
                        <td>{{ $car->color }}</td>
                        <td>{{ $car->found_location }}</td>
                    </tr>
                </tbody>
            </table>
        @else
            <p class="alert alert-danger">لم يتم العثور على أي سيارة.</p>
        @endif
    </div>
@endsection
