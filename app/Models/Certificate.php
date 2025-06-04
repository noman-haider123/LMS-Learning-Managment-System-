<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    protected $fillable = [
        'Course_id',
        'Student_id',
        'Created_by'
    ];
    public function courses(){
        return $this->belongsTo(Course::class,'Course_id');
    }
    public function students(){
        return $this->belongsTo(Student::class,'Student_id');
    }
    public function users(){
        return $this->belongsTo(User::class,'Created_by');
    }
    
}
