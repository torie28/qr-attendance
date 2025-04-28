<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = ['name', 'code'];

    public function students()
    {
        return $this->hasMany(User::class);
    }
}