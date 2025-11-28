<?php

namespace App\Http\Controllers;

use App\Models\PoliceStation;
use App\Models\SearchNotification;
use Illuminate\Http\Request;
use App\Models\Car;
use Exception;

class CarController extends Controller
{
    // عرض الصفحة الرئيسية
    public function index()
    {
        try {
            $cars = Car::with('policeStation')->get();
            return view('index', compact('cars'));
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'حدث خطأ أثناء جلب البيانات: ' . $e->getMessage());
        }
    }

    // عرض صفحة إدخال السيارات
    public function create()
    {
        try {
            $policeStations = PoliceStation::all();
            return view('admin.add-car', compact('policeStations'));
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'حدث خطأ أثناء جلب البيانات: ' . $e->getMessage());
        }
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
            $car = Car::create([
                'chassis_number' => $request->chassis_number,
                'model' => $request->model,
                'color' => $request->color,
                'found_location' => $request->found_location,
                'police_station_id' => $request->police_station_id,
            ]);

            // التحقق من وجود إشعارات في انتظار لهذا الرقم
            $pendingNotifications = SearchNotification::pendingForChassis($request->chassis_number)->get();

            if ($pendingNotifications->count() > 0) {
                // تحديث جميع الإشعارات المعلقة
                foreach ($pendingNotifications as $notification) {
                    $notification->markAsNotified();
                }

                // إضافة رسالة إضافية تفيد بإرسال الإشعارات
                $successMessage = 'تمت إضافة السيارة بنجاح وتم إشعار ' . $pendingNotifications->count() . ' مستخدم';
            } else {
                $successMessage = 'تمت إضافة السيارة بنجاح';
            }

            // إرسال رسالة نجاح والعودة للوحة التحكم
            return redirect()->route('admin-dashboard')->with('success', $successMessage);
        } catch (Exception $e) {
            // إرسال رسالة خطأ
            return redirect()->back()->with('error', 'حدث خطأ أثناء إضافة السيارة: ' . $e->getMessage());
        }
    }

    // البحث عن سيارة برقم الشاسيه
    public function search(Request $request)
    {
        try {
            $chassis = trim($request->input('chassis_number')); // إزالة المسافات
            $car = Car::where('chassis_number', $chassis)->first();

            if ($car) {
                return view('search', ['car' => $car]);
            } else {
                // حفظ طلب الإشعار إذا طلب المستخدم ذلك
                $subscribeToNotifications = $request->input('subscribe_notifications');

                if ($subscribeToNotifications) {
                    SearchNotification::create([
                        'chassis_number' => $chassis,
                        'user_email' => $request->input('user_email'),
                        'search_date' => now(),
                    ]);

                    return view('search', [
                        'message' => 'السيارة غير موجودة لرقم الشاسيه: ' . $chassis,
                        'subscribed' => true
                    ]);
                }

                return view('search', ['message' => 'السيارة غير موجودة لرقم الشاسيه: ' . $chassis]);
            }
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'حدث خطأ أثناء البحث: ' . $e->getMessage());
        }
    }

    // التحقق من الإشعارات
    public function checkNotifications(Request $request)
    {
        try {
            $email = $request->input('email');

            if (!$email) {
                return view('notifications', ['error' => 'يرجى إدخال البريد الإلكتروني']);
            }

            $notifications = SearchNotification::where('user_email', $email)
                ->with('car')
                ->orderBy('created_at', 'desc')
                ->get();

            return view('notifications', [
                'email' => $email,
                'notifications' => $notifications
            ]);
        } catch (Exception $e) {
            return view('notifications', ['error' => 'حدث خطأ أثناء البحث عن الإشعارات: ' . $e->getMessage()]);
        }
    }

    // دالة عرض لوحة التحكم
    public function dashboard()
    {
        try {
            $cars = Car::all(); // جميع السيارات المخزنة
            return view('dashboard', compact('cars'));
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'حدث خطأ أثناء جلب البيانات: ' . $e->getMessage());
        }
    }

    // دالة لحذف السيارة
    public function destroy($id)
    {
        try {
            $car = Car::findOrFail($id);
            $car->delete(); // حذف السيارة من قاعدة البيانات
            return redirect('/dashboard')->with('success', 'تم حذف السيارة بنجاح');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'حدث خطأ أثناء حذف السيارة: ' . $e->getMessage());
        }
    }

    // دالة تعديل السيارة
    public function edit($id)
    {
        try {
            $car = Car::findOrFail($id);
            $policeStations = PoliceStation::all();
            return view('admin.edit-car', compact('car', 'policeStations'));
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'حدث خطأ أثناء جلب البيانات: ' . $e->getMessage());
        }
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

        try {
            $car = Car::findOrFail($id);
            $car->update($request->all());
            return redirect()->route('admin-dashboard')->with('success', 'تم تحديث السيارة بنجاح');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'حدث خطأ أثناء تحديث السيارة: ' . $e->getMessage());
        }
    }

    // API Methods for Postman debugging

    // Get all cars (API)
    public function apiIndex()
    {
        try {
            $cars = Car::with('policeStation')->get();
            return response()->json([
                'success' => true,
                'data' => $cars,
                'count' => $cars->count()
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching cars: ' . $e->getMessage()
            ], 500);
        }
    }

    // Search car by chassis number (API)
    public function apiSearch(Request $request)
    {
        try {
            $chassis = trim($request->input('chassis_number'));
            if (!$chassis) {
                return response()->json([
                    'success' => false,
                    'message' => 'Chassis number is required'
                ], 400);
            }

            $car = Car::with('policeStation')->where('chassis_number', $chassis)->first();

            if ($car) {
                return response()->json([
                    'success' => true,
                    'data' => $car
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Car not found for chassis number: ' . $chassis
                ], 404);
            }
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error searching car: ' . $e->getMessage()
            ], 500);
        }
    }

    // Get specific car by ID (API)
    public function apiShow($id)
    {
        try {
            $car = Car::with('policeStation')->findOrFail($id);
            return response()->json([
                'success' => true,
                'data' => $car
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Car not found'
            ], 404);
        }
    }

    // Create new car (API)
    public function apiStore(Request $request)
    {
        $request->validate([
            'chassis_number' => 'required|string|unique:cars,chassis_number|min:10|max:20',
            'model' => 'required|string|max:50',
            'color' => 'required|string|max:30',
            'found_location' => 'required|string|max:100',
            'police_station_id' => 'required|exists:police_stations,id',
        ]);

        try {
            $car = Car::create($request->all());
            return response()->json([
                'success' => true,
                'message' => 'Car created successfully',
                'data' => $car
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error creating car: ' . $e->getMessage()
            ], 500);
        }
    }

    // Update car (API)
    public function apiUpdate(Request $request, $id)
    {
        $request->validate([
            'chassis_number' => 'required|unique:cars,chassis_number,' . $id,
            'model' => 'required|string|max:50',
            'color' => 'required|string|max:30',
            'found_location' => 'required|string|max:100',
            'police_station_id' => 'required|exists:police_stations,id',
        ]);

        try {
            $car = Car::findOrFail($id);
            $car->update($request->all());
            return response()->json([
                'success' => true,
                'message' => 'Car updated successfully',
                'data' => $car
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating car: ' . $e->getMessage()
            ], 500);
        }
    }

    // Delete car (API)
    public function apiDestroy($id)
    {
        try {
            $car = Car::findOrFail($id);
            $car->delete();
            return response()->json([
                'success' => true,
                'message' => 'Car deleted successfully'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting car: ' . $e->getMessage()
            ], 500);
        }
    }
}
