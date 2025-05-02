<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Attendance;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'email',
        'password',
        'role'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];


    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isStudent()
    {
        return $this->role === 'student';
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function attendancePercentage()
    {
        $totalClasses = $this->attendances()->distinct('course_id')->count('course_id');
        $attendedClasses = $this->attendances()->count();

        return $totalClasses > 0 ? round(($attendedClasses / $totalClasses) * 100, 2) : 0;
    }
}