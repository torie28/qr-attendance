<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name',
        'admission_number',
        'course',
        'password',
        'role'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function attendancePercentage($courseId = null)
    {
        $query = $this->attendances();
        
        if ($courseId) {
            $query->where('course_id', $courseId);
        }

        $totalClasses = Attendance::count();
        $attendedClasses = $query->count();

        return $totalClasses > 0 ? ($attendedClasses / $totalClasses) * 100 : 0;
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isStudent()
    {
        return $this->role === 'student';
    }
}