<!-- filepath: /c:/xampp/htdocs/alhosh/resources/views/edit-car.blade.php -->
@extends('layout.apps')
@section('title', 'تعديل سيارة')

@section('content')
    <div class="container mt-5">
        <h2>تعديل سيارة</h2>
        <!--رسائل النجاح و الخطأ-->
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        @if (isset($car))
            <form action="{{ route('update-car', $car->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">رقم الشاسيه:</label>
                    <input type="text" class="form-control" name="chassis_number" value="{{ $car->chassis_number }}" required>
                    @if ($errors->has('chassis_number'))
                        <div class="alert alert-danger mt-2">{{ $errors->first('chassis_number') }}</div>
                    @endif
                </div>

                <div class="mb-3">
                    <label class="form-label">الموديل:</label>
                    <input type="text" class="form-control" name="model" value="{{ $car->model }}" required>
                    @if ($errors->has('model'))
                        <div class="alert alert-danger mt-2">{{ $errors->first('model') }}</div>
                    @endif
                </div>

                <div class="mb-3">
                    <label class="form-label">اللون:</label>
                    <input type="text" class="form-control" name="color" value="{{ $car->color }}" required>
                    @if ($errors->has('color'))
                        <div class="alert alert-danger mt-2">{{ $errors->first('color') }}</div>
                    @endif
                </div>

                <div class="mb-3">
                    <label class="form-label">مكان العثور عليها:</label>
                    <input type="text" class="form-control" name="found_location" value="{{ $car->found_location }}" required>
                    @if ($errors->has('found_location'))
                        <div class="alert alert-danger mt-2">{{ $errors->first('found_location') }}</div>
                    @endif
                </div>
                <div class="mb-3">
                    <label class="form-label"> عنوان قسم الشرطه:</label>
                    <select name="police_station_id" class="form-control" id="police_station">
                        @foreach ($policeStations as $station)
                            <option value="{{ $station->id }}" {{ $car->police_station_id == $station->id ? 'selected' : '' }}>{{ $station->address }}</option>
                        @endforeach
                    </select>
                    @if ($errors->has('police_station_id'))
                        <div class="alert alert-danger mt-2">{{ $errors->first('police_station_id') }}</div>
                    @endif
                </div>
                <button type="submit" class="btn btn-success">تحديث</button>
            </form>
        @else
            <div class="alert alert-danger">لم يتم العثور علي السيارة</div>
        @endif
    </div>
@endsection