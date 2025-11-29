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

    // صفحة التقارير
    public function reports()
    {
        try {
            // إحصائيات السيارات حسب التواريخ
            $totalCars = Car::count();
            $storedCars = Car::where('status', 'stored')->count();
            $foundCars = Car::where('status', 'found')->count();

            // إحصائيات شهرية
            $monthlyStats = Car::selectRaw('
                YEAR(created_at) as year,
                MONTH(created_at) as month,
                COUNT(*) as total_cars,
                SUM(CASE WHEN status = "found" THEN 1 ELSE 0 END) as found_cars
            ')
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->limit(12)
            ->get();

            // إحصائيات حسب مراكز الشرطة
            $policeStationStats = Car::selectRaw('
                police_stations.name as station_name,
                COUNT(cars.id) as total_cars,
                SUM(CASE WHEN cars.status = "found" THEN 1 ELSE 0 END) as found_cars
            ')
            ->join('police_stations', 'cars.police_station_id', '=', 'police_stations.id')
            ->groupBy('police_stations.id', 'police_stations.name')
            ->orderBy('total_cars', 'desc')
            ->get();

            return view('admin.reports', compact(
                'totalCars',
                'storedCars',
                'foundCars',
                'monthlyStats',
                'policeStationStats'
            ));
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'حدث خطأ أثناء تحميل التقارير: ' . $e->getMessage());
        }
    }
}
