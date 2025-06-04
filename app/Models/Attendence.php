<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendence extends Model
{
    protected $fillable = [
        'student_id',
        'teacher_id',
        'teacher_email_address',
        'date',
        'status',
        'Created_By',
    ];
    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }   
    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }
}
