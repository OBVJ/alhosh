@extends('layout.app')
@section('title', 'لوحه التحكم')
@section('content')
<div class="container mt-5">
    <h2>لوحه تحكم القسم</h2>

    @if(session('success'))
    <div class="alert alert-success">{{session('success')}}</div>
    @endif

    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th>رقم الشاسيه</th>
                <th>الموديل</th>
                <th>اللون</th>
                <th>مكان العثور</th>
                <th>الاجراءات</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($cars as $car )
            <tr>
                <td>{{$car->chassis_number}}</td>
                <td>{{$car->model}}</td>
                <td>{{$car->color}}</td>
                <td>{{$car->found_location}}</td>
                <td><a href="{{route('edit-car',$car->id)}}" class="btn btn-primary btn-sm">تعديل</a>
                <form action="{{route('delete-car',$car->id)}}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm">حذف</button>
                </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection