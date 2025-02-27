@extends('layout.apps')
@section('title','البحث عن السيارات المفقوده')

@section('content')
    <div class="container mt-5">
        <h2>البحث عن السيارات المفقوده</h2>
        
        <!--رسائل النجاح و الخطأ-->
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <form action="{{ route('search') }}" method="GET">
           @csrf
            <div class="mb-3">
                <label for="chassis_number" class="form-label">ادخل رقم الشاسيه:</label>
                <input type="text" class="form-control" id="chassis_number" name="chassis_number" required>
                @if ($errors->has('chassis_number'))
                    <div class="alert alert-danger mt-2">{{ $errors->first('chassis_number') }}</div>
                @endif
            </div>
            <button type="submit" class="btn btn-primary">بحث</button>
        </form>

        @if (isset($car))
            <h3 class="mt-5">نتائج البحث</h3>
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
        @endif
    </div>
@endsection