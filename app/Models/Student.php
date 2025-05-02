<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Attendance;
use App\Models\Course;

class Student extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'admission_number',
        'course',
        'password',
        'role'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $attributes = [
        'role' => 'student'
    ];

    /**
     * Get the name of the unique identifier for the user.
     *
     * @return string
     */
    public function getAuthIdentifierName()
    {
        return 'admission_number';
    }

    /**
     * Get the unique identifier for the user.
     *
     * @return mixed
     */
    public function getAuthIdentifier()
    {
        return $this->admission_number;
    }

    /**
     * Get the password for the user.
     *
     * @return string
     */
    public function getAuthPassword()
    {
        return $this->password;
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Relationship with attendance records
     */
    public function attendances()
    {
        return $this->hasMany(Attendance::class, 'student_id');
    }

    /**
     * Calculate attendance percentage
     */
    public function attendancePercentage()
    {
        $totalClasses = $this->attendances()->count();
        $presentClasses = $this->attendances()->where('status', 'present')->count();

        if ($totalClasses == 0) {
            return 0;
        }

        return round(($presentClasses / $totalClasses) * 100, 2);
    }
}
