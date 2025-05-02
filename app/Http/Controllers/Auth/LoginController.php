<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Student;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login (fallback).
     *
     * @var string
     */
    protected $redirectTo = '/';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Override login to allow email or admission number.
     */
    public function login(Request $request)
    {
        // Validate inputs
        $request->validate([
            'login' => 'required|string',
            'password' => 'required|string',
        ]);

        $login = $request->input('login');
        $password = $request->input('password');

        // Attempt student login
        $student = Student::where('admission_number', $login)->first();
        
        if ($student) {
            \Log::info('Student Found', [
                'admission_number' => $login,
                'student_id' => $student->id,
                'password_match' => Hash::check($password, $student->password)
            ]);
        }

        if ($student && Hash::check($password, $student->password)) {
            // Ensure role is set
            $student->role = 'student';
            $student->save();

            Auth::login($student);
            $request->session()->regenerate();
            
            // Debugging: Verify authentication
            \Log::info('Student Login Successful', [
                'user_id' => $student->id,
                'authenticated' => Auth::check(),
                'authenticated_user_role' => Auth::user()->role ?? 'no role'
            ]);

            return $this->authenticated($request, $student);
        }

        // Then attempt admin login
        if (Auth::attempt(['email' => $login, 'password' => $password], $request->remember)) {
            $request->session()->regenerate();
            return $this->authenticated($request, Auth::user());
        }

        // Log failed login attempt
        \Log::warning('Login Failed', [
            'login_attempt' => $login,
            'student_exists' => (bool)$student
        ]);

        return back()->withErrors([
            'login' => 'Invalid credentials. Please try again.',
        ])->withInput();
    }

    /**
     * Redirect users based on their role after login.
     */
    protected function authenticated(Request $request, $user)
    {
        // Comprehensive logging
        \Log::info('Authentication Attempt', [
            'user_id' => $user->id,
            'user_role' => $user->role ?? 'no role',
            'user_type' => get_class($user)
        ]);

        // Debugging: Print out all available routes
        \Log::info('Available Named Routes', [
            'routes' => array_keys(\Route::getRoutes()->getRoutesByName())
        ]);

        if ($user->role === 'admin') {
            return redirect()->route('admindashboard');
        } elseif ($user->role === 'student') {
            return redirect()->route('studentdashboard');
        }

        // Fallback redirect
        return redirect('/');
    }

    /**
     * Logout handler.
     */
    public function logout(Request $request)
    {
        $this->guard()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
