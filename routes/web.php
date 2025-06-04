<?php

use App\Http\Controllers\CourseController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentAttendenceController;
use App\Http\Controllers\StudentCertificateController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherAttendenceController;
use App\Http\Controllers\UpdateController;
use App\Http\Controllers\Why_Choose_UsController;
use Illuminate\Support\Facades\Route;

Route::get('/dashboard',[Why_Choose_UsController::class,'dashboard'])->middleware(['auth', 'verified'])->name('dashboard');
Route::get('/',[CourseController::class,'showcourse'])->name('/');
Route::post('/pay', [PaymentController::class, 'checkout'])->name('checkout');
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource("/students",StudentController::class);
    Route::put('/std/{id}',[UpdateController::class, 'edit'])->name('update');
    Route::get('/create',[UpdateController::class, 'create'])->name('createrole');
    Route::post('/storerole',[UpdateController::class, 'store'])->name('role');
    Route::put('/AssignRole/{AssignRole}',[UpdateController::class, 'AssignRole'])->name('AssignRole');
    Route::get('/createpermission',[UpdateController::class, 'createpermission'])->name('createpermission');
    Route::post('/storePermission',[UpdateController::class, 'storePermission'])->name('storePermission');
    Route::put('/assignPermission/{assignPermission}',[UpdateController::class, 'assignPermission'])->name('assignPermission');
    Route::get('/index', [StudentAttendenceController::class, 'index'])->name('index');
    Route::post('/storeattendeces', [StudentAttendenceController::class, 'store'])->name('store');
    Route::put('/Update/{Attendences}', [StudentAttendenceController::class, 'Update'])->name('Update');
    Route::delete('/destroy/{destroy}', [StudentAttendenceController::class, 'destroy'])->name('destroy');
    Route::get('/course', [CourseController::class, 'index'])->name('course');
    Route::post('/store', [CourseController::class, 'store'])->name('course.store');
    Route::put('/edit/{edit}', [CourseController::class, 'edit'])->name('courseedit');
    Route::delete('/coursedestroy/{coursedestroy}', [CourseController::class, 'destroy'])->name('coursedestroy');
    Route::post('/checkIn', [TeacherAttendenceController::class, 'checkIn'])->name('checkIn');
    Route::post('/checkOut', [TeacherAttendenceController::class, 'checkOut'])->name('checkOut');
    Route::get('/teachertrack', [TeacherAttendenceController::class, 'index'])->name('teachertrack');
    Route::get('/whychooseme', [Why_Choose_UsController::class, 'index'])->name('whychooseme');
    Route::post('/whychoosemestore', [Why_Choose_UsController::class, 'store'])->name('whychoosemestore');
    Route::put('/whychoosemeedit/{whychoosemeedit}', [Why_Choose_UsController::class, 'edit'])->name('whychoosemeedit');
    Route::delete('/whychoosemedestroy/{whychoosemedestroy}', [Why_Choose_UsController::class, 'destroy'])->name('whychoosemedestroy');
    Route::get('/jobindex', [JobController::class, 'index'])->name('jobindex');
    Route::post('/jobstore', [JobController::class, 'store'])->name('jobstore');
    Route::put('/jobedit/{jobedit}', [JobController::class, 'edit'])->name('jobedit');
    Route::delete('/jobdestroy/{jobdestroy}', [JobController::class, 'destroy'])->name('jobdestroy');
    Route::get('/payments', [PaymentController::class, 'index'])->name('payments');
    Route::get('/certificate', [StudentCertificateController::class, 'index'])->name('certificate');
    Route::post('/certificatestore', [StudentCertificateController::class, 'store'])->name('certificatestore');
    Route::put('/certificateedit/{certificateedit}', [StudentCertificateController::class, 'edit'])->name('certificateedit');
    Route::delete('/certificatdestroy/{certificatedestroy}', [StudentCertificateController::class, 'destroy'])->name('certificatedestroy');
    Route::get('/certificate/download/{download}', [StudentCertificateController::class, 'download'])->name('certificate.download');
});

require __DIR__.'/auth.php';
