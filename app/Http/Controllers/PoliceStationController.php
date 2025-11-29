<?php

namespace App\Http\Controllers;

use App\Models\PoliceStation;
use Illuminate\Http\Request;
use Exception;

class PoliceStationController extends Controller
{
    // عرض جميع أقسام الشرطة
    public function index()
    {
        try {
            $policeStations = PoliceStation::with('cars')->get();
            return view('admin.police-stations.index', compact('policeStations'));
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'حدث خطأ أثناء جلب البيانات: ' . $e->getMessage());
        }
    }

    // عرض صفحة إضافة قسم شرطة جديد
    public function create()
    {
        return view('admin.police-stations.create');
    }

    // حفظ قسم شرطة جديد
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100|unique:police_stations,name',
            'location' => 'required|string|max:255',
        ], [
            'name.required' => 'اسم القسم مطلوب',
            'name.unique' => 'اسم القسم موجود بالفعل',
            'name.max' => 'اسم القسم يجب أن لا يزيد عن 100 حرف',
            'location.required' => 'موقع القسم مطلوب',
            'location.max' => 'موقع القسم يجب أن لا يزيد عن 255 حرف',
        ]);

        try {
            PoliceStation::create([
                'name' => $request->name,
                'location' => $request->location,
            ]);

            return redirect()->route('police-stations.index')->with('success', 'تمت إضافة قسم الشرطة بنجاح');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'حدث خطأ أثناء إضافة قسم الشرطة: ' . $e->getMessage());
        }
    }

    // عرض صفحة تعديل قسم شرطة
    public function edit($id)
    {
        try {
            $policeStation = PoliceStation::findOrFail($id);
            return view('admin.police-stations.edit', compact('policeStation'));
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'حدث خطأ أثناء جلب البيانات: ' . $e->getMessage());
        }
    }

    // تحديث قسم شرطة
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:100|unique:police_stations,name,' . $id,
            'location' => 'required|string|max:255',
        ], [
            'name.required' => 'اسم القسم مطلوب',
            'name.unique' => 'اسم القسم موجود بالفعل',
            'name.max' => 'اسم القسم يجب أن لا يزيد عن 100 حرف',
            'location.required' => 'موقع القسم مطلوب',
            'location.max' => 'موقع القسم يجب أن لا يزيد عن 255 حرف',
        ]);

        try {
            $policeStation = PoliceStation::findOrFail($id);
            $policeStation->update($request->all());

            return redirect()->route('police-stations.index')->with('success', 'تم تحديث قسم الشرطة بنجاح');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'حدث خطأ أثناء تحديث قسم الشرطة: ' . $e->getMessage());
        }
    }

    // حذف قسم شرطة
    public function destroy($id)
    {
        try {
            $policeStation = PoliceStation::findOrFail($id);

            // تحقق من عدم وجود سيارات مرتبطة بهذا القسم
            if ($policeStation->cars()->count() > 0) {
                return redirect()->back()->with('error', 'لا يمكن حذف قسم الشرطة لأنه يحتوي على سيارات مرتبطة به');
            }

            $policeStation->delete();

            return redirect()->route('police-stations.index')->with('success', 'تم حذف قسم الشرطة بنجاح');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'حدث خطأ أثناء حذف قسم الشرطة: ' . $e->getMessage());
        }
    }
}
