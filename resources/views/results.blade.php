@extends('layout.apps')
@section('title', 'نتائج البحث')

@section('content')
    <div class="container mt-5">
        <h2>نتائج البحث عن السيارة</h2>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        @if (isset($cars) && count($cars) > 0)
            <h3 class="mt-5">نتائج البحث</h3>
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
                            <td>{{ $car->policeStation->name ?? 'غير محدد' }}</td>
                            <td>
                                <a href="{{ route('edit-car', $car->id) }}">تعديل</a>
                                <form action="{{ route('delete-car', $car->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit">حذف</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>لا توجد نتائج للبحث.</p>
        @endif
    </div>
@endsection
