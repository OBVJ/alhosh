<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

Route::get('/', [CarController::class, 'index'])->name('index'); // الصفحة الرئيسية

// البحث عن سيارة (استخدام GET بدلاً من POST)
Route::get('/search', [CarController::class, 'search'])->name('search'); 

// حماية مسارات الإضافة والحذف والتعديل بـ middleware
Route::middleware(['auth', 'police_admin'])->group(function () {
    Route::get('/add-car', [CarController::class, 'create'])->name('add-car'); // صفحة إضافة سيارة
    Route::post('/store-car', [CarController::class, 'store'])->name('store-car'); // حفظ السيارة
    Route::get('/edit-car/{id}', [CarController::class, 'edit'])->name('edit-car'); // تعديل السيارة
    Route::post('/update-car/{id}', [CarController::class, 'update'])->name('update-car'); // تحديث بيانات السيارة
    Route::delete('/delete-car/{id}', [CarController::class, 'destroy'])->name('delete-car'); // حذف السيارة
});

// لوحة التحكم للمستخدمين المسجلين
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [CarController::class, 'dashboard'])->name('dashboard');
});

// حماية لوحة تحكم الأدمن
Route::middleware(['auth', 'police_admin'])->group(function () {
    Route::get('/admin-dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
});

// إدارة الملف الشخصي
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// تحميل ملفات المصادقة
require __DIR__.'/auth.php';
