<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\auth\LoginController;
use App\Http\Controllers\auth\RegisterController;
use App\Http\Controllers\AttendanceController;
use Illuminate\Support\Facades\Auth;

// login routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// registration routes
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// Role-based dashboard routes
Route::middleware(['auth'])->group(function () {
    // Student Dashboard
    Route::get('/studentdashboard', function () {
        $user = Auth::user();
        $attendancePercentage = $user->attendancePercentage();
        $attendances = $user->attendances;
        return view('studentdashboard', compact('user', 'attendancePercentage', 'attendances'));
    })->name('studentdashboard');

    // Admin Dashboard
    Route::get('/admindashboard', function () {
        $courses = \App\Models\Course::all();
        $students = \App\Models\User::where('role', 'student')->get();
        return view('admindashboard', compact('courses', 'students'));
    })->name('admindashboard');

    // Attendance routes
    Route::post('/mark-attendance', [AttendanceController::class, 'markAttendance'])->name('mark-attendance');
    Route::get('/attendance', [AttendanceController::class, 'viewAttendance'])->name('attendance');
});

Route::get('/qr-test', function () {
    $writer = new \Endroid\QrCode\Writer\PngWriter();
    $qrCode = new \Endroid\QrCode\QrCode('Test QR Code');
    
    $result = $writer->write($qrCode);
    
    return response($result->getString())
        ->header('Content-Type', $result->getMimeType());
})->name('qr.test');

Route::get('/qr-view', function () {
    return view('qr-code');
})->name('qr.view');

Route::get('/', function () {
    return view('home');
});