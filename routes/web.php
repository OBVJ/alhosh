<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PoliceStationController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| هنا يتم تعريف المسارات الخاصة بالمشروع. 
|
*/

// الصفحة الرئيسية (متاحة للجميع)
Route::get('/', [CarController::class, 'index'])->name('index');

// صفحة البحث عن السيارات (متاحة للجميع)
// تأكد أن نموذج البحث يستخدم طريقة GET.
Route::get('/search', [CarController::class, 'search'])->name('search');

// صفحة التحقق من الإشعارات
Route::get('/notifications', [CarController::class, 'checkNotifications'])->name('notifications');


// مجموعة المسارات المحمية للمستخدمين المسجلين (auth + verified)
Route::middleware(['auth', 'verified'])->group(function () {
    // لوحة التحكم الخاصة بالمستخدمين (عامة)
    Route::get('/dashboard', [CarController::class, 'dashboard'])->name('dashboard');

    // إدارة الملف الشخصي
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


// مجموعة المسارات الخاصة بإدارة السيارات (متاحة فقط للمستخدمين ذوي صلاحيات المسؤول)
// هنا يستخدم middleware "police_admin" لضمان أن العمليات مثل إضافة وتعديل وحذف السيارات تقتصر على المسؤولين.
Route::middleware(['auth', 'police_admin'])->group(function () {
    // صفحة إضافة سيارة جديدة
    Route::get('/add-car', [CarController::class, 'create'])->name('add-car');
    // حفظ بيانات السيارة
    Route::post('/store-car', [CarController::class, 'store'])->name('store-car');
    // تعديل السيارة
    Route::get('/edit-car/{id}', [CarController::class, 'edit'])->name('edit-car');
    // تحديث بيانات السيارة
    Route::put('/update-car/{id}', [CarController::class, 'update'])->name('update-car');
    // حذف السيارة
    Route::delete('/delete-car/{id}', [CarController::class, 'destroy'])->name('delete-car');

    // لوحة تحكم المسؤول (Admin Dashboard)
    Route::get('/admin-dashboard', [AdminController::class, 'admin'])->name('admin-dashboard');

    // إدارة أقسام الشرطة
    Route::get('/police-stations', [PoliceStationController::class, 'index'])->name('police-stations.index');
    Route::get('/police-stations/create', [PoliceStationController::class, 'create'])->name('police-stations.create');
    Route::post('/police-stations', [PoliceStationController::class, 'store'])->name('police-stations.store');
    Route::get('/police-stations/{id}/edit', [PoliceStationController::class, 'edit'])->name('police-stations.edit');
    Route::put('/police-stations/{id}', [PoliceStationController::class, 'update'])->name('police-stations.update');
    Route::delete('/police-stations/{id}', [PoliceStationController::class, 'destroy'])->name('police-stations.destroy');
});

// تحميل مسارات المصادقة (auth routes)
require __DIR__.'/auth.php';
