<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Car;
use App\Models\PoliceStation;
use Exception;

class AdminController extends Controller
{
    public function admin()
    {
        try {
            // جلب السيارات بناءً على القسم التابع للمستخدم
            $cars = Car::all();

            // عرض الصفحة مع البيانات
            return view('admin.dashboard', compact('cars'));
        } catch (Exception $e) {
            // تسجيل الخطأ وعرض رسالة خطأ للمستخدم
            return redirect()->route('index')->with('error', 'حدث خطأ أثناء تحميل لوحة التحكم: ' . $e->getMessage());
        }
    }

    // API method to get all police stations
    public function apiPoliceStations()
    {
        try {
            $policeStations = PoliceStation::all();
            return response()->json([
                'success' => true,
                'data' => $policeStations,
                'count' => $policeStations->count()
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching police stations: ' . $e->getMessage()
            ], 500);
        }
    }
}
