<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Attendance extends Model
{
    protected $fillable = ['user_id', 'course_id', 'date', 'time', 'qr_code'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}