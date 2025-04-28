<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Course;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AttendanceController extends Controller
{
    public function generateQRCode(Course $course)
    {
        $qrCode = Str::random(20);
        // Here you would integrate with a QR code generation library
        return view('qr-code', compact('qrCode', 'course'));
    }

    public function markAttendance(Request $request)
    {
        $validatedData = $request->validate([
            'admission_number' => 'required|exists:users,admission_number',
            'course_id' => 'required|exists:courses,id',
            'qr_code' => 'required'
        ]);

        $user = User::where('admission_number', $validatedData['admission_number'])->first();
        
        $attendance = Attendance::create([
            'user_id' => $user->id,
            'course_id' => $validatedData['course_id'],
            'date' => now()->toDateString(),
            'time' => now()->toTimeString(),
            'qr_code' => $validatedData['qr_code']
        ]);

        return redirect()->route('dashboard')->with('success', 'Attendance marked successfully');
    }

    public function viewAttendance()
    {
        $user = Auth::user();
        $attendancePercentage = $user->attendancePercentage();
        $attendances = $user->attendances;

        return view('attendance', compact('attendancePercentage', 'attendances'));
    }
}