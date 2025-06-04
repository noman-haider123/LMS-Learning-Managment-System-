<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobPlacement extends Model
{
    protected $fillable = [
        'Student_Name',
        'Student_Review',
        'Student_Position',
        'Student_Image'
    ];
}
