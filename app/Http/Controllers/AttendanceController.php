<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Course;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class AttendanceController extends Controller
{
    public function generateQRCode(Course $course)
    {
        $qrCode = Str::random(20);
        $courseName = $course->name;
        $courseCode = $course->code;

        // Here you would integrate with a QR code generation library
        return view('qr-code', compact('qrCode', 'course', 'courseName', 'courseCode'));
    }

    public function markAttendance(Request $request)
    {
        $validatedData = $request->validate([
            'token' => 'required|string',
            'admission_number' => 'required|exists:users,admission_number'
        ]);

        try {
            // Retrieve course information from cache
            $courseInfo = Cache::get('attendance_token_' . $validatedData['token']);
            
            if (!$courseInfo) {
                throw new \Exception('Invalid or expired attendance token');
            }

            // Validate the course exists
            $course = Course::findOrFail($courseInfo['course_id']);

            // Find the user
            $user = User::where('admission_number', $validatedData['admission_number'])->firstOrFail();
            
            // Create attendance record
            $attendance = Attendance::create([
                'user_id' => $user->id,
                'course_id' => $course->id,
                'date' => now()->toDateString(),
                'time' => now()->toTimeString(),
                'qr_code' => $validatedData['token']
            ]);

            // Remove the token from cache after successful use
            Cache::forget('attendance_token_' . $validatedData['token']);

            return redirect()->route('dashboard')->with('success', 'Attendance marked successfully for ' . $course->name);
        } catch (\Exception $e) {
            // Handle various potential errors
            return back()->withErrors(['message' => 'Unable to mark attendance: ' . $e->getMessage()]);
        }
    }

    public function viewAttendance()
    {
        $user = Auth::user();
        $attendancePercentage = $user->attendancePercentage();
        $attendances = $user->attendances;

        return view('attendance', compact('attendancePercentage', 'attendances'));
    }
}