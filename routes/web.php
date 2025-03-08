<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\AdminController;
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


// مجموعة المسارات المحمية للمستخدمين المسجلين (auth + verified)
Route::middleware(['auth', 'verified'])->group(function () {
    // لوحة التحكم الخاصة بالمستخدمين (عامة)
    Route::get('/dashboard', [CarController::class, 'dashboard'])->name('dashboard');

    // إدارة الملف الشخصي
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile-edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile-update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile-destroy');
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
    Route::get('/admin-dashboard', [AdminController::class, 'index'])->name('admin-dashboard');
});

// تحميل مسارات المصادقة (auth routes)
require __DIR__.'/auth.php';
