<?php

namespace App\Http\Controllers;

use App\Models\PoliceStation;
use Illuminate\Http\Request;
use App\Models\Car;

class CarController extends Controller
{
    // عرض الصفحة الرئيسية
    public function index()
    {
        $cars = Car::with('policeStation')->get();
        return view('index',compact('cars'));
    }

    // عرض صفحة إدخال السيارات
    public function create()
    {
        $PoliceStation = PoliceStation::all();
        return view('add-car', compact('PoliceStation'));
    }

    // حفظ بيانات السيارات في قاعدة البيانات
    public function store(Request $request)
    {
        // التحقق من صحة البيانات المدخلة
        $request->validate([
            'chassis_number' => 'required|string|unique:cars,chassis_number|min:10|max:20',
            'model' => 'required|string|max:50',
            'color' => 'required|string|max:30',
            'found_location' => 'required|string|max:100',
            'police_station_id' => 'required|exists:police_stations,id',
        ], [
            'chassis_number.required' => 'رقم الشاسيه مطلوب',
            'chassis_number.unique' => 'رقم الشاسيه موجود بالفعل',
            'chassis_number.min' => 'رقم الشاسيه يجب أن يكون 10 أرقام على الأقل',
            'chassis_number.max' => 'رقم الشاسيه يجب أن لا يزيد عن 20 رقم',
            'model.required' => 'الموديل مطلوب',
            'color.required' => 'اللون مطلوب',
            'color.max' => 'اللون يجب أن لا يزيد عن 30 حرف',
            'found_location.required' => 'مكان العثور مطلوب',
            'found_location.max' => 'مكان العثور يجب أن لا يزيد عن 100 حرف',
        'police_station_id.required' => 'يجب اختيار مركز الشرطة',
        'police_station_id.exists' => 'مركز الشرطة غير موجود',
        
        
        ]);

        try {
            
            // إنشاء السيارة الجديدة
            Car::create([
                'chassis_number' => $request->chassis_number,
                'model' => $request->model,
                'color' => $request->color,
                'found_location' => $request->found_location,
                'police_station_id' => $request->police_station_id,
            ]);

            // إرسال رسالة نجاح
            return redirect()->back()->with('success', 'تمت الإضافة بنجاح');
        } catch (\Exception $e) {
            // إرسال رسالة خطأ
            return redirect()->back()->with('error', 'حدث خطأ أثناء إضافة السيارة');
        }
    }

    // البحث عن سيارة برقم الشاسيه
    public function search(Request $request)
    {
        $chassis = trim($request->input('chassis_number')); // إزالة المسافات
        $car = Car::where('chassis_number', $chassis)->first();
    
        if ($car) {
            return view('results', ['car' => $car]);
        } else {
            return view('results', ['message' => 'السيارة غير موجودة لرقم الشاسيه: ' . $chassis]);
        }
      // عرض النتائج باستخدام الملف "results.blade.php"
   
    }

    // دالة عرض لوحة التحكم
    public function dashboard()
    {
        $cars = Car::all(); // جميع السيارات المخزنة
        return view('dashboard', compact('cars'));
    }

    // دالة لحذف السيارة
    public function destroy($id)
    {
        $car = Car::findOrFail($id);
        $car->delete(); // حذف السيارة من قاعدة البيانات
        return redirect('/dashboard')->with('success', 'تم حذف السيارة بنجاح');
    }

    // دالة تعديل السيارة
    public function edit($id)
    {
        $car = Car::findOrFail($id);
        $policeStations = PoliceStation::all();
        return view('admin.edit-car', compact('car', 'policeStations'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'chassis_number' => 'required|unique:cars,chassis_number,' . $id,
            'model' => 'required',
            'color' => 'required',
            'found_location' => 'required',
            'police_station_id' => 'required|exists:police_stations,id',
        ]);

        $car = Car::find($id);

        if (!$car) {
            return redirect()->back()->with('error', 'لم يتم العثور على السيارة');
        }

        $car->update($request->all());
        return redirect('/dashboard')->with('success', 'تم التحديث بنجاح');
    }
}
