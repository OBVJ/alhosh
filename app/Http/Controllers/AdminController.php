<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\Car;
//use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $cars = Car::where('police_station_id',Auth::user()->police_station_id)->get();
        return view('admin.dashboard',compact('cars'));
    }
}
