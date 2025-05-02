<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class StudentDashboardController extends Controller
{
    public function index(Request $request)
    {
        // Extensive logging for debugging
        \Log::error('Student Dashboard Access Attempt', [
            'user_authenticated' => Auth::check(),
            'user_id' => Auth::id(),
            'user_role' => Auth::user()->role ?? 'no role',
            'user_type' => get_class(Auth::user())
        ]);

        $user = Auth::user();
        
        // Check if the authenticated user is a student
        if (!$user instanceof \App\Models\Student) {
            \Log::error('Non-student user attempting to access student dashboard', [
                'user_id' => $user->id,
                'user_type' => get_class($user)
            ]);
            return redirect('/')->with('error', 'Unauthorized access');
        }

        try {
            $attendancePercentage = $user->attendancePercentage();
            $attendances = $user->attendances;
        } catch (\Exception $e) {
            \Log::error('Error fetching student data', [
                'error' => $e->getMessage(),
                'user_id' => $user->id
            ]);
            $attendancePercentage = 0;
            $attendances = collect();
        }
        
        return view('studentdashboard', compact('user', 'attendancePercentage', 'attendances'));
    }
}