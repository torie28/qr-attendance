<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\auth\LoginController;
use App\Http\Controllers\auth\RegisterController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\StudentDashboardController;
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
    // Student Dashboard with explicit controller
    Route::get('/studentdashboard', [StudentDashboardController::class, 'index'])
        ->name('studentdashboard');

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
    $courseName = request('course_name', 'Test Course');
    $courseCode = request('course_code', 'TST001');
    
    $writer = new \Endroid\QrCode\Writer\PngWriter();
    $qrCode = new \Endroid\QrCode\QrCode("Course: {$courseCode} - {$courseName}");
    
    $result = $writer->write($qrCode);
    
    return response($result->getString())
        ->header('Content-Type', $result->getMimeType());
})->name('qr.test');

Route::get('/qr-view', function () {
    $courseName = 'Default Course';
    $courseCode = 'DEF001';
    return view('qr-code', compact('courseName', 'courseCode'));
})->name('qr-code');

Route::get('/', function () {
    return view('home');
});