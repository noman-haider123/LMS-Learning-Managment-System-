<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeacherAttendance extends Model
{
    protected $fillable = [
        'teacher_id',
        'ip_address',
        'location',
        'latitude',
        'longitude',
        'check_in_time',
        'check_out_time'
    ];
    public function users()
    {
        return $this->belongsTo(User::class,'teacher_id');
    }
}
