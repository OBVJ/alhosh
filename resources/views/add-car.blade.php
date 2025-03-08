@extends('layout.apps')
@section('title', 'اضافة سيارة')

@section('content')

    <div class="container mt-5">
        <h2>اضافة سياره جديده</h2>
        <!--رسائل النجاح و الخطأ-->
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <form action="{{ route('store-car') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="chassis_number" class="form-label">رقم الشاسيه:</label>
                <input type="text" class="form-control" id="chassis_number" name="chassis_number" required>
                @if ($errors->has('chassis_number'))
                    <div class="alert alert-danger mt-2">{{ $errors->first('chassis_number') }}</div>
                @endif
            </div>

            <div class="mb-3">
                <label for="model" class="form-label">الموديل:</label>
                <input type="text" class="form-control" id="model" name="model" required>
                @if ($errors->has('model'))
                    <div class="alert alert-danger mt-2">{{ $errors->first('model') }}</div>
                @endif
            </div>

            <div class="mb-3">
                <label for="color" class="form-label">اللون:</label>
                <input type="text" class="form-control" id="color" name="color" required>
                @if ($errors->has('color'))
                    <div class="alert alert-danger mt-2">{{ $errors->first('color') }}</div>
                @endif
            </div>

            <div class="mb-3">
                <label for="found_location" class="form-label">مكان العثور عليها:</label>
                <input type="text" class="form-control" id="found_location" name="found_location" required>
                @if ($errors->has('found_location'))
                    <div class="alert alert-danger mt-2">{{ $errors->first('found_location') }}</div>
                @endif
            </div>

            <div class="mb-3">
                <label for="police_station" class="form-label"> عنوان قسم الشرطه:</label>
                <select name="police_station_id" class="form-control" id="police_station" required>
                    @foreach ($PoliceStation as $station)
                        <option value="{{ $station->id }}">{{ $station->address }}</option>
                    @endforeach
                </select>
                @if ($errors->has('police_station_id'))
                    <div class="alert alert-danger mt-2">{{ $errors->first('police_station_id') }}</div>
                @endif
            </div>

            <button type="submit" class="btn btn-success">اضافة</button>
        </form>

        <!--تعديلات للتحقق من صحه المدخلات في البحث-->
        @if ($errors->any())
            <div class="alert alert-danger mt-3">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <a href="{{ route('search') }}" class="btn btn-primary mt-3">البحث عن سيارة</a>
    </div>

@endsection
